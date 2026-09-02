/**
 * Carbon Fields media_gallery passes multiple: true to wp.media.
 * WordPress treats that as "Ctrl/Cmd-click to add"; a regular click
 * replaces the selection, so the picker feels single-select.
 * multiple: 'add' lets each click accumulate attachments.
 */
(function (wp) {
	if (!wp || typeof wp.media !== 'function' || wp.media.__makeTravelMultiselect) {
		return;
	}

	var originalMedia = wp.media;

	function isGalleryPicker(attributes) {
		if (!attributes || typeof attributes !== 'object') {
			return false;
		}

		if (attributes.multiple === true || attributes.multiple === 'add') {
			return true;
		}

		var title = String(attributes.title || '');
		return title === 'Select Attachments' || title === 'Select Media';
	}

	function enableAddMode(frame) {
		if (!frame) {
			return;
		}

		if (frame.options) {
			frame.options.multiple = 'add';
		}

		function applyToState(state) {
			if (!state || typeof state.get !== 'function') {
				return;
			}

			var selection = state.get('selection');
			if (selection) {
				selection.multiple = 'add';
			}
		}

		if (typeof frame.state === 'function') {
			applyToState(frame.state());
		}

		if (frame.states && typeof frame.states.each === 'function') {
			frame.states.each(applyToState);
		}
	}

	function patchedMedia(attributes) {
		if (isGalleryPicker(attributes)) {
			attributes = Object.assign({}, attributes, { multiple: 'add' });
		}

		var frame = originalMedia(attributes);

		if (frame && attributes && attributes.multiple === 'add') {
			enableAddMode(frame);
			frame.on('ready open', function () {
				enableAddMode(frame);
			});
		}

		return frame;
	}

	Object.keys(originalMedia).forEach(function (key) {
		patchedMedia[key] = originalMedia[key];
	});

	patchedMedia.__makeTravelMultiselect = true;
	wp.media = patchedMedia;

	document.addEventListener('click', function (event) {
		var target = event.target;
		if (!target || typeof target.closest !== 'function') {
			return;
		}

		if (!target.closest('.cf-media-gallery__browse')) {
			return;
		}

		window.setTimeout(function () {
			var frames = wp.media.frames;
			if (frames) {
				Object.keys(frames).forEach(function (key) {
					enableAddMode(frames[key]);
				});
			}

			enableAddMode(wp.media.frame);
		}, 0);
	}, true);
})(window.wp);

export function estimateSinglePostReadTime() {
  const root = document.querySelector('.single-post'); 
  const article = document.querySelector('.h-article');
  const title = document.querySelector('.post__title');
  const excerpt = document.querySelector('.post__excerpt');
  const readTimeEl = document.querySelector('.post__read-time');

  if (!readTimeEl || !root) return;

  let textContent = '';

  if (title) textContent += ' ' + title.innerText;
  if (excerpt) textContent += ' ' + excerpt.innerText;
  if (article) textContent += ' ' + article.innerText;

  const words = textContent
    .trim()
    .split(/\s+/)
    .filter(Boolean).length;

  const pictures = root.querySelectorAll('picture').length;
  const images = root.querySelectorAll('img').length;
  console.log('Images:', images);

  const imageCount = Math.max(pictures, images);

  const videoCount = root.querySelectorAll('video').length;

  const READ_SPEED = 200;
  const IMAGE_TIME = 10; // seconds
  const VIDEO_TIME = 1.25;

  const wordsTime = words / READ_SPEED;
  const imagesTime = (imageCount * IMAGE_TIME) / 60;
  const videosTime = videoCount * VIDEO_TIME;

  const totalTime = Math.ceil(wordsTime + imagesTime + videosTime);

  readTimeEl.textContent =
    totalTime <= 1
      ? 'Less than 1 min read'
      : `${totalTime} min read`;
}
window.addEventListener("DOMContentLoaded", () => {
  // (A) GET ALL IMAGES
  var all = document.querySelectorAll(".gallery img");

  // (B) CLICK ON IMAGE TO TOGGLE FULLSCREEN
  if (all.length > 0) {
    for (let img of all) {
      img.onclick = () => {
        // Toggle full-screen class
        img.classList.toggle("full");

        // Get the corresponding caption elements
        var captionNonFull = img.nextElementSibling;
        var captionFull = img.nextElementSibling.nextElementSibling;

        if (img.classList.contains("full")) {
          // Image is in full-screen mode
          captionNonFull.style.display = "none";
          captionFull.style.display = "block";
        } else {
          // Image is not in full-screen mode
          captionNonFull.style.display = "block";
          captionFull.style.display = "none";
        }
      };
    }
  }
});

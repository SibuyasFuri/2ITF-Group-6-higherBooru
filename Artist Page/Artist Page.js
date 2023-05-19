window.addEventListener("DOMContentLoaded", () => {
  // Get All Images
  var all = document.querySelectorAll(".gallery img");

  // Click on Image to Toggle Fullscreen
  if (all.length > 0) {
    for (let img of all) {
      img.onclick = () => {
        // Toggle Full-Screen Class
        img.classList.toggle("full");

        // Get the Corresponding Caption Elements
        var captionNonFull = img.nextElementSibling;
        var captionFull = img.nextElementSibling.nextElementSibling;

        if (img.classList.contains("full")) {
          // Image is in Full-Screen Mode
          captionNonFull.style.display = "none";
          captionFull.style.display = "block";
          
          // Disable Scrolling
          document.body.style.overflow = "hidden";
          
        } else {
          // Image is Not in Full-Screen Mode
          captionNonFull.style.display = "block";
          captionFull.style.display = "none";
          
          // Enable Scrolling
          document.body.style.overflow = "auto";
        }
      };
    }
  }
});
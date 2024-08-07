window.onload = () => {
    var videoSource = document.querySelector("source");
    if (Math.floor(Math.random() * 2) == 1) {
        videoSource.setAttribute("src", "1.mp4");
    } else {
        videoSource.setAttribute("src", "2.mp4");
    }

    var video = document.querySelector("video");

    video.load();
    window.addEventListener("mousemove", () => {
        video.play();
    });

};

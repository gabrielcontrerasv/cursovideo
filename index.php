<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
$isFinished = false;
$viewed = false;
$playing = false;

if (isset($_POST['viewed'])) {
  $viewed = true;
  $isFinished = true;
}

if (isset($_POST['playing'])) {
  $playing = true;
}
?>
<style>
  .video-container{
    display:block;
    max-width: 70%;
    margin: auto;
    border:1px solid;
    overflow:hidden;
    border-radius: 10px;
  }
  .video{
    display: flex;
    justify-content:center
    max-width: 100%;
    width: 100%
  }

  .controls {
    display: flex;
    justify-content:center
    max-width: 100%;
    width: 100%;
    background: #fb006b;
    padding:10px;
    align-items:center;
  }
  .timebar{
    width: 85%;
    height: 30px;
  }
  .speed, button{
    padding: 9px;
    margin:2px;
    background-color:white;
    border-radius: 5px;
    border: 2px solid #fb006b; 
    cursor:pointer;
  }

  .player-container:-webkit-full-screen {
  width: 100%;
  height: 100%;
}

</style>

<div class="player-container">


<div class="video-container">
  <div>
  <video
    class="video"
    onended="videoEnded()"
    ontimeupdate="videoViewed()"
  >
    <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
  </video>
</div>
<div class="controls">
  <?php if (!$playing): ?>
    <button class="play-button" onclick="playVideo()"><i class="fa fa-play"></i></button>
    <button class="play-button" onclick="videoPause()"><i class="fa fa-stop"></i></button>
    <progress class="timebar" max="100" value=0></progress>
    <strong>

    <select name="speed" class="speed" onchange="if (this.selectedIndex) speedIncrese();">
        <option value="0" selected>1.0x</option>
        <option value="1">1.5x</option>
        <option value="2">2.0x</option>
      </select>
    </strong>
    <button class="play-button" onclick="fullScreen()"><i class="fa fa-expand"></i></button>
  <?php endif; ?>
  </div>
  </div>
  </div>

<script>

  const video = document.querySelector('video');
  function playVideo() {
    video.play();
    sendRequest('playing');
  }

  const speeds = [1.0,1.5,2.0]
  function speedIncrese() {
      speed = document.querySelector('select').selectedIndex
      video.playbackRate = speeds[speed]; 
  }

  function videoPause() {
    video.pause();
  }

  function videoEnded() {
    sendRequest('viewed');
  }

  function fullScreen() {
    var video = document.querySelector("video");
    if (video.requestFullscreen) {
      video.requestFullscreen();
    }

    /*if ((document.fullScreenElement && document.fullScreenElement !== null) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
    */
  }

  function videoViewed() {
    const viewedPercentage = (video.currentTime / video.duration) * 100;
    document.querySelector('progress').value = viewedPercentage;
    
  /*  switch(viewedPercentage){
      case viewedPercentage > 25:
        sendRequest({stage1:true})
      continue  
      case viewedPercentage > 50:
        sendRequest({stage1:true,
                     stage2:true
                    })  
      continue              
      case viewedPercentage > 75:
        sendRequest({stage1:true,
                     stage2:true,
                     stage3:true
                    })          
      break                    
    }
    */
  }

  function sendRequest(action) {
    fetch('videoPlayer.php', {
      method: 'POST',
      body: new URLSearchParams({
        [action]: true
      })
    });
  }
</script>


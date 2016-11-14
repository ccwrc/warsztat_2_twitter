
$(document).ready(function() {

  var divMainLogo = $('#mainBackLogo');
  var smallImageDivMainLogo = $('#logoimage');
 
  var backLogoSound = new Audio('sound_sample/backlogosound.mp3');
  var logoSound = new Audio('sound_sample/logosound.mp3');

    // start i stop dla dzwieku na belce gornej
  divMainLogo.on('mouseenter', function() {
    backLogoSound.play();
  });

  divMainLogo.on('mouseleave', function() {
    backLogoSound.pause();
    backLogoSound.currentTime = 0;
  });
  
    // start i stop dla dzwieku na malym logo (gora, lewa strona)
  smallImageDivMainLogo.on('mouseenter', function() {
    logoSound.play();
  });

  smallImageDivMainLogo.on('mouseleave', function() {
    logoSound.pause();
    logoSound.currentTime = 0;
  });



});


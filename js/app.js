
$(document).ready(function () {

    var divMainLogo = $('#mainBackLogo');
    var smallImageDivMainLogo = $('#logoimage');

    var backLogoSound = new Audio('sound_sample/backlogosound.mp3');
    var logoSound = new Audio('sound_sample/logosound.mp3');

    // start i stop dla dzwieku na belce gornej
    divMainLogo.on('mouseenter', function () {
        backLogoSound.play();
    });

    divMainLogo.on('mouseleave', function () {
        backLogoSound.pause();
        backLogoSound.currentTime = 0;
    });

    // start i stop dla dzwieku na malym logo (gora, lewa strona)
    smallImageDivMainLogo.on('mouseenter', function () {
        logoSound.play();
    });

    smallImageDivMainLogo.on('mouseleave', function () {
        logoSound.pause();
        logoSound.currentTime = 0;
    });

    // zwykly licznik dla pol tekstowych
    var counterInNewSpan = function (max, textArea) {
        var count = 0;
        var newSpan = $("<span>");
        textArea.after(newSpan);

        textArea.on("keyup", function () {
            count = $(this)[0].value.length;

            if (count > max) {
                $(this)[0].value = $(this)[0].value.substr(0, max);
                count = max;
            }
            $("span")[0].innerText = count + "/" + max;

            if (count < 3) {
                $("span").css("color", "black");
            } else if (count < (max * 0.95)) {
                $("span").css("color", "green");
            } else {
                $("span").css("color", "red");
            }
        });
    };

    // podpinanie licznika do pol tekstowych - tablica id
    var idsForCounterArray = [
        "#newTweetOnIndex", "#usernameCreateUser", "#userEmailCreateUser",
        "#userPassword1CreateUser", "#userPassword2CreateUser", "#newCommentToTweetOnDetail",
        "#newUsernameOnEditUser", "#oldPasswordOnEditUser", "#oldPassword2onEditUser",
        "#newPassword1onEditUser", "#newPassword2onEditUser", "#oldPassword3onEditUser",
        "#userEmailOnLogon", "#userPasswordOnLogon", "#newMessageOnShowUser",
        "#usernameSearchUser"
    ];
    // podpinanie licznika do pol tekstowych
    for (var i = 0; i < idsForCounterArray.length; i++) {
        counterInNewSpan($(idsForCounterArray[i]).data("max_char_input"), $(idsForCounterArray[i]));
    }

});


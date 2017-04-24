
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
            console.log($(this));

            if (count > max) {
                $(this)[0].value = $(this)[0].value.substr(0, max);
                count = max;
            }
            $("span")[0].innerText = count + "/" + max;

            if (count < 3) {
                $("span").css("color", "greenyellow");
            } else if (count < (max * 0.95)) {
                $("span").css("color", "green");
            } else {
                $("span").css("color", "red");
            }
        });
    };

    // podpinanie licznika do pol tekstowych
    counterInNewSpan($("#newTweetOnIndex").data("max_char_input"), $("#newTweetOnIndex"));
    counterInNewSpan($("#usernameCreateUser").data("max_char_input"), $("#usernameCreateUser"));
    counterInNewSpan($("#userEmailCreateUser").data("max_char_input"), $("#userEmailCreateUser"));
    counterInNewSpan($("#userPassword1CreateUser").data("max_char_input"), $("#userPassword1CreateUser"));
    counterInNewSpan($("#userPassword2CreateUser").data("max_char_input"), $("#userPassword2CreateUser"));
    counterInNewSpan($("#newCommentToTweetOnDetail").data("max_char_input"), $("#newCommentToTweetOnDetail"));
    counterInNewSpan($("#newUsernameOnEditUser").data("max_char_input"), $("#newUsernameOnEditUser"));
    counterInNewSpan($("#oldPasswordOnEditUser").data("max_char_input"), $("#oldPasswordOnEditUser"));
    counterInNewSpan($("#oldPassword2onEditUser").data("max_char_input"), $("#oldPassword2onEditUser"));
    counterInNewSpan($("#newPassword1onEditUser").data("max_char_input"), $("#newPassword1onEditUser"));
    counterInNewSpan($("#newPassword2onEditUser").data("max_char_input"), $("#newPassword2onEditUser"));
    counterInNewSpan($("#oldPassword3onEditUser").data("max_char_input"), $("#oldPassword3onEditUser"));
    counterInNewSpan($("#userEmailOnLogon").data("max_char_input"), $("#userEmailOnLogon"));
    counterInNewSpan($("#userPasswordOnLogon").data("max_char_input"), $("#userPasswordOnLogon"));
    
    var idsForCounterArray = [
        "newTweetOnIndex", "usernameCreateUser", "userEmailCreateUser", "userPassword1CreateUser",
        "userPassword2CreateUser", "newCommentToTweetOnDetail", "newUsernameOnEditUser",
        "oldPasswordOnEditUser", "oldPassword2onEditUser", "newPassword1onEditUser",
        "newPassword2onEditUser", "oldPassword3onEditUser", "userEmailOnLogon", 
        "userPasswordOnLogon"
    ];
//
//    for (var i = 0; i < idForCounterArray.length; i++) {
//        var data1 = "\"#" + idForCounterArray[i] + "\""; console.log(data1);
//        counterInNewSpan($(data1).data("max_char_input"), $(data1));
//    }

});


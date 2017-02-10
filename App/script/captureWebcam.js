(function() {
    var streaming = false,
    video        = document.querySelector('#video'),
    cover        = document.querySelector('#cover'),
    canvas       = document.querySelector('#canvas'),
    photo        = document.querySelector('#photo'),
    startbutton  = document.querySelector('#startbutton'),
    width = 320,
    height = 0;

    if(!video)
        return;
    navigator.getMedia = (
        navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia
    );

    navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
        if (navigator.mozGetUserMedia) {
            video.mozSrcObject = stream;
        } else {
            var vendorURL = window.URL || window.webkitURL;
            video.src = vendorURL.createObjectURL(stream);
        }
        video.play()
        var monEvenement = new CustomEvent(
            "monEvenement",
            {
                detail: {
                message: navigator.getMedia,
                time: new Date()
                },
                bubbles: false,
                cancelable: false
            }
        );

        // abonnement du bouton "Destinaitaire événement" à l'événement
        var eventDestination = document.getElementById("video");
        eventDestination.addEventListener("monEvenement", function(event) {
          // console.log("Reception de l'evenement");
          // console.log(event.detail.message);
        });
        document.getElementById("video").dispatchEvent(monEvenement);
    },
    function(err) {
      //console.log("An error occured! " + err);
    }
    );

    video.addEventListener('canplay', function(ev){
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth/width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    }, false);

         canvas.width = width;
        canvas.height = height;

    var ctx=canvas.getContext('2d');
    var i;
    // Canevas en direct
    // video.addEventListener('play',function() {i=window.setInterval(function() {takepicture()},30);},false);
    // video.addEventListener('pause',function() {window.clearInterval(i);},false);
    // video.addEventListener('ended',function() {clearInterval(i);},false);
    document.getElementsByAttribute = function(querySelector, attribute) {
        var validAttr = new Array();
        for(var i = 0; i < querySelector.length; i++)
        {
            if(querySelector[i].getAttribute('data-x')) {
                validAttr.push(querySelector[i]);
            }
        }
        return validAttr;
    }
    name = 1;
    function takepicture() {
        var test = document.getElementById('test');
        var toto = document.getElementsByAttribute(document.querySelectorAll('.draggableBox'),'data-x');
        canvas.width = width;
        canvas.height = height;
        var context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, width, height);
        for(var i = 0; i < toto.length; i++) {
            context.drawImage(toto[i], toto[i].getAttribute('data-x'), toto[i].getAttribute('data-y'), toto[i].width, toto[i].height);
        }
        var data = canvas.toDataURL('image/png');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/takePicture', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
        xhr.onload = function () {
        if (xhr.status === 200) {
                var myArr = JSON.parse(this.responseText);
                addImg(myArr.src, myArr.id);
            } else {

            }
        };
        xhr.send("donnee=" + data + "&token=" + token);
    }

    function addImg(src, id) {
        var newLink = document.createElement('img');
        var myPicture = document.getElementById('myPictures');
        newLink.id = id;
        newLink.src = src;
        myPicture.insertBefore(newLink, myPicture.childNodes[2]);
    }

    startbutton.addEventListener('click', function(ev){
        takepicture();
        ev.preventDefault();
    }, false);
})();

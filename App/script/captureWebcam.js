function trash(id)
{
    xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/takePicture/' + id, true);

        xhr.onload = function () {
        if (xhr.status === 200) {
                var trash = document.getElementById(id);
                var next = trash.nextSibling;
                next.parentNode.removeChild(next);
                trash.parentNode.removeChild(trash);
            } else {

            }
        };
    xhr.send();
}

(function() {
    var streaming = false,
    video        = document.querySelector('#video'),
    cover        = document.querySelector('#cover'),
    canvas       = document.querySelector('#canvas'),
    photo        = document.querySelector('#photo'),
    startbutton  = document.querySelector('#startbutton'),
    startGif     = document.querySelector('#startGif'),
    width = 320,
    height = 0,
    canvasInUse = false;

    var intVal = null;
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
        });
        document.getElementById("video").dispatchEvent(monEvenement);
    },
    function(err) {

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
    //var i;
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
    // function takepicture() {
    //     var imgSup = document.getElementsByAttribute(document.querySelectorAll('.draggableBox'),'data-x');
    //     if(imgSup.length == 0) {
    //         return;
    //     }
    //     canvas.width = width;
    //     canvas.height = height;
    //     var context = canvas.getContext('2d');
    //     context.drawImage(video, 0, 0, width, height);
    //     for(var i = 0; i < imgSup.length; i++) {
    //         context.drawImage(imgSup[i], imgSup[i].getAttribute('data-x'), imgSup[i].getAttribute('data-y'), imgSup[i].width, imgSup[i].height);
    //     }
    //     var data = canvas.toDataURL('image/png');
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('POST', '/takePicture', true);
    //     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    //     xhr.onload = function () {
    //     if (xhr.status === 200) {
    //             var myArr = JSON.parse(this.responseText);
    //             addImg(myArr.src, myArr.id);
    //         } else {

    //         }
    //     };
    //     xhr.send("donnee=" + data + "&token=" + token);
    // }

    function createDonnee(type = 'png')
    {
        var imgSup = document.getElementsByAttribute(document.querySelectorAll('.draggableBox'),'data-x');
        var context, data, xhr, donnee;
        if(imgSup.length == 0 && type == 'png') {
            return false;
        }
        if(canvasInUse == false) {
            canvas.width = width;
            canvas.height = height;
            context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, width, height);
        } else {
            document.getElementById("files").value = "";
            canvas.style.display = 'none';
            video.style.display = 'inline';
            canvasInUse = false;
        }
        donnee = "donnee=" + canvas.toDataURL('image/png') + "&width=" + width + "$height=" + height;
        for(var i = 0; i < imgSup.length; i++) {
            var src = imgSup[i].getAttribute('src');
            var widthSup =  imgSup[i].width;
            var heightSup = imgSup[i].height
            var dataXSup = imgSup[i].getAttribute('data-x');
            var dataYSup = imgSup[i].getAttribute('data-y');
            imgSup[i].style.position = 'static';
            imgSup[i].style.top = imgSup[i].offsetTop + 'px';
            imgSup[i].style.left = imgSup[i].offsetLeft + 'px';
            imgSup[i].style.top = imgSup[i].offsetTop + 'px';
            imgSup[i].style.left = imgSup[i].offsetLeft + 'px';
            imgSup[i].removeAttribute('data-y');
            imgSup[i].removeAttribute('data-x');
            imgSup[i].style.width = "";
            imgSup[i].style.height = "";
            donnee += "&src" + i + "=" + src + "&width" + i + "=" + widthSup + "&height" + i + "=" + heightSup + "&dataX" + i + "=" + dataXSup + "&dataY" + i + "=" + dataYSup;
        }
        donnee += "&token=" + token;
        return donnee;
    }

    function takepicture(url) {
        var donnee = createDonnee('png');
        if (donnee == false)
        {
            return;
        }
        xhr = new XMLHttpRequest();
        xhr.open('POST', '/' + url);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
        xhr.onload = function () {
            if (xhr.status == 200) {
                var myArr = JSON.parse(this.responseText);
                if (!myArr.error) {
                    addImg(myArr.src, myArr.id);
                    donnee = "";
                }
            } else {

            }
        };
        xhr.send(donnee);
    }
    var frame = [];
    function takeGif(url)
    {
        var donnee = createDonnee('gif');
        if(frame.length < 10) {
            donnee += '&type=gifTmp';
            xhr = new XMLHttpRequest();
            xhr.open('POST', '/takePicture');
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            xhr.onload = function () {
            if (xhr.status == 200) {
                    var myArr = JSON.parse(this.responseText);
                    if (!myArr.error) {
                        frame.push(myArr.src);
                    }
                } else {
                    window.clearInterval(intVal);
                    frame = [];
                }
            };
            xhr.send(donnee);
        } else {
            donnee = 'donnee=gif&type=gif&gif=' + JSON.stringify(frame);
            xhr = new XMLHttpRequest();
            xhr.open('POST', '/takePicture');
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            xhr.onload = function () {
            if (xhr.status === 200) {
                    var myArr = JSON.parse(this.responseText);
                    if (!myArr.error) {
                        addImg(myArr.src, myArr.id);
                        window.clearInterval(intVal);
                        frame = [];
                        intVal = null;
                    }
                } else {
                    window.clearInterval(intVal);
                    frame = [];
                    intVal = null;
                }
            };
            xhr.send(donnee);
        }
    }

    function addImg(src, id) {
        var newLink = document.createElement('img');
        var myPicture = document.getElementById('myPictures');
        var newTrash = document.createElement('img');
        var newClass = document.createAttribute("class");
        var newClass1 = document.createAttribute("class");
        newClass.value = 'myPicture';
        newClass1.value = 'trash';
        newLink.id = id;
        newLink.src = src;
        newLink.setAttributeNode(newClass);
        newTrash.id = id;
        newTrash.src = "/src/img/poubelle.png";
        newTrash.addEventListener('click',function(){trash(id)},false);
        newTrash.setAttributeNode(newClass1);
        myPicture.insertBefore(newTrash, myPicture.childNodes[2]);
        myPicture.insertBefore(newLink, myPicture.childNodes[3]);
    }

    startbutton.addEventListener('click', function(ev){
        takepicture('takePicture');
        ev.preventDefault();
    }, false);

    startGif.addEventListener('click', function(ev){
        if(intVal == null) {
            intVal = window.setInterval(function() {takeGif('takeGif')},500);
        }
    }, false);

    document.getElementById("files").onchange = function (e) {
        canvas       = document.querySelector('#canvas');
        canvas.style.display = 'inline';
        video.style.display = 'none';
        var ctx = canvas.getContext('2d');
        var reader = new FileReader();
        reader.onload = function(event){
            var img = new Image();
            img.onload = function(){
                canvas.width = width;
                canvas.height = height;
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, width, height);
                ctx.drawImage(img,0,0, width, height);
            }
            img.src = event.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);

        canvasInUse = true;
    };

})();

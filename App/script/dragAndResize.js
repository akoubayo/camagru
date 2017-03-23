function hasClass(element, className) {
    return element.className && new RegExp("(^|\\s)" + className + "(\\s|$)").test(element.className);
}
(function() { // On utilise une IIFE pour ne pas polluer l'espace global
    var storage = {}; // Contient l'objet de la div en cours de déplacement
    var resize = 0;
    var onUse = false;
    var posLeft = document.querySelector('#gal');
    function init() { // La fonction d'initialisation

        var elements = document.getElementsByTagName('img'),
            elementsLength = elements.length;

        for (var i = 0 ; i < elementsLength ; i++) {
            if (elements[i].className === 'draggableBox') {
                if(parseInt(elements[i].height) > parseInt(document.querySelector('#gal').style.height))
                    elements[i].style.height =parseInt(document.querySelector('#gal').style.height) - 10 + 'px';
                posLeft += 70;
                elements[i].addEventListener('mousedown', function(e) { // Initialise le drag & drop
                    var s = storage;
                    s.target                 = e.target;
                    s.target.style.position  = 'absolute';
                    s.target.style.width     =  s.target.width + 'px';
                    s.target.style.height    = s.target.height + 'px';
                    s.offsetX                = e.clientX - s.target.offsetLeft;
                    s.offsetY                = e.clientY - s.target.offsetTop;
                    s.target.style.width     =  s.target.width + 'px';
                    // For risize img
                    startX = e.clientX;
                    startY = e.clientY;
                    startWidth = s.target.width;
                    startHeight = s.target.height;
                }, false);
                elements[i].addEventListener('mouseup', function(e) { // Termine le drag & drop
                    storage = {};
                    onUse = false;
                }, false);
                elements[i].addEventListener('mouseenter', function(e) {
                    e.target.style.border = '3px dotted black';
                }, false);
                elements[i].addEventListener('mouseleave', function(e) {
                    if(onUse == false) e.target.style.border = 'none';
                }, false);
            }
        }

        document.addEventListener('mouseup', function(e) { // Termine le drag & drop
            storage = {};
            onUse = false;
        }, false);

        document.addEventListener('mousemove', function(e) { // Permet le suivi du drag & drop
            var target = storage.target;
            var video = document.querySelector('#video');
            if (video && video.style.display == 'none'){
                video = document.querySelector('#canvas');
            }
            if (target) {
                if (storage.offsetY <= 20 && storage.offsetX >= 0 && storage.offsetX <= 20 || onUse=='topL') {
                    target.style.width = (startWidth - e.clientX + startX) + 'px';
                    target.style.height = (startHeight - e.clientY + startY) + 'px';
                    target.style.top = e.clientY + 'px';
                    target.style.left = e.clientX + 'px';
                    onUse = 'topL';

                }
                else if (storage.offsetY <= 20 && storage.offsetX >= (parseInt(target.width)-20) || onUse=='topR') {
                    target.style.width = (startWidth + e.clientX - startX) + 'px';
                    target.style.height = (startHeight - e.clientY + startY) + 'px';
                    target.style.top = e.clientY + 'px';
                    onUse = 'topR';
                }
                else if (storage.offsetY >= (parseInt(target.height)-20) && storage.offsetX < 20 || onUse=='bottomL') {
                    target.style.width = (startWidth - e.clientX + startX) + 'px';
                    target.style.height = (startHeight + e.clientY - startY) + 'px';
                    target.style.left = e.clientX + 'px';
                    onUse = 'bottomL';
                }
                else if (storage.offsetY >= (parseInt(target.height)-20) && storage.offsetX > (parseInt(target.width)-20) || onUse=='bottomR') {
                    target.style.width = (startWidth + e.clientX - startX) + 'px';
                    target.style.height = (startHeight + e.clientY - startY) + 'px';
                    onUse = 'bottomR';
                }
                else {
                    target.style.cursor = 'move';
                    target.style.top = e.clientY - storage.offsetY + 'px';
                    target.style.left = e.clientX - storage.offsetX + 'px';
                    target.setAttribute('data-y', target.offsetTop - video.offsetTop);
                    target.setAttribute('data-x', target.offsetLeft - video.offsetLeft);
                }
            }

            if (hasClass(e.target, 'draggableBox')) {
                if (e.offsetY <= 20 && e.offsetX >= -5 && e.offsetX <= 20 || onUse=='topL')
                    e.target.style.cursor = 'nwse-resize';
                else if (e.offsetY <= 20 && e.offsetX >= (parseInt(e.target.width)-20) || onUse=='topR')
                    e.target.style.cursor = 'nesw-resize';
                else if (e.offsetY >= (parseInt(e.target.height)-20) && e.offsetX < 20 || onUse=='bottomL')
                    e.target.style.cursor = 'nesw-resize';
                else if (e.offsetY >= (parseInt(e.target.height)-20) && e.offsetX > (parseInt(e.target.width)-20) || onUse=='bottomR')
                    e.target.style.cursor = 'nwse-resize';
                else
                    e.target.style.cursor = 'move';
            }
        }, false);
    }
    init(); // On initialise le code avec notre fonction toute prête.
})();

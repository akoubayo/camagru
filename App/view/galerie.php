<div id="galerie">

</div>
<div class="paginationBtn">
    <button onclick="pageFct.prev()"><<</button>
    <span id="corpPagination">
        <input type="text" name="" id="page" value="1"> /
        <span id="nbPage"></span>
    </span>
    <button onclick="pageFct.next()">>></button>
</div>
<script>

    var pagination = function()
    {
        this.page = 1;
        this.limit = 10;
        this.offset = 0;
        this.totalPage = 0;

        this.pagination = function(total)
        {
            var nbPage = document.querySelector('#nbPage');
            this.totalPage = Math.ceil(total/this.limit) || 1;
            nbPage.innerHTML = this.totalPage;
        }

        this.next = function()
        {
            if(this.page < this.totalPage)
            {
                document.querySelector('#page').value = ++this.page;
                this.offset = this.limit * ( this.page - 1);
                getImage();
            }
        }

        this.prev = function()
        {
            if(this.page > 1)
            {
                 document.querySelector('#page').value = --this.page;
                 this.offset = this.limit * ( this.page - 1);
                 getImage();
            }
        }
    }
    var pageFct = new pagination();

    function addImg(src, id)
    {
        var newSpan = document.createElement('span');
        var newImg = document.createElement('img');
        var newA = document.createElement('a');
        var newClass = document.createAttribute("class");
        var newRel = document.createAttribute("rel");
        newClass.value = "spanImg";
        newRel.value = id;
        newImg.id = id;
        newImg.src = src;
        newA.href = '/galerie/' + id;
        newSpan.setAttributeNode(newClass);
        newSpan.setAttributeNode(newRel);
        newSpan.append(newA);
        newA.append(newImg)
        //newSpan.onclick = enLarge;

        return newSpan;
    }
    // function enLarge()
    // {
    //     var width = 20;
    //     var img = this.querySelector('img');
    //     var body = document.querySelector('body');
    //     body.addEventListener("click", close,true);
    //     var elem = document.getElementsByClassName('modal')[0];
    //     var newImg = document.createElement('img');
    //     elem.style.backgroundColor = "white";
    //     elem.style.position = 'absolute';
    //     elem.style.top = 10 + 'px';
    //     elem.style.display = "block";

    //     var id = setInterval(frame, 10);
    //     function frame() {
    //         if (width == 100) {
    //           clearInterval(id);
    //         } else {
    //           elem.style.width = width + '%';
    //           if(width < 50) {
    //               //img.style.width = elem.offsetWidth + 'px';
    //           }
    //           width++;
    //         }
    //     }
    //     // this.style.display = 'inline-block';
    //     // this.style.width = '100%';
    //     // this.style.border = '1px solid black';
    // }

    // function close(offsetWidth)
    // {
    //     var elem = document.getElementsByClassName('modal')[0]
    //     elem.style.width = 0 + 'px';
    //     elem.style.display = 'none';
    // }

    function getImage()
    {
        var galerie = document.querySelector('#galerie');
        xhr = new XMLHttpRequest();
        xhr.open('GET', '/showPictures?limit=' + pageFct.limit + '&offset=' + pageFct.offset, true);
        xhr.onload = function () {
        if (xhr.status === 200) {
                var myArr = JSON.parse(this.responseText);
                galerie.innerHTML = '';
                for (var i = 0 ; i < myArr.pictures.length ; i++) {
                    galerie.append(addImg('/src/imgsave/' + myArr.pictures[i].src + '.png',myArr.pictures[i].id_pictures))
                }
                pageFct.pagination(myArr.count);
            } else {

            }
        };
        xhr.send();
    }(getImage());
</script>

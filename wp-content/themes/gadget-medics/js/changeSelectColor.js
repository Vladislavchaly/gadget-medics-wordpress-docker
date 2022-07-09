jQuery(document).ready( function() {
    // Пересоздаем список
function createCustomColorSelect() {
    var blurBox = document.getElementsByClassName('blurBg-select')[0]
    var body = document.body
    var selectOpened = false
    var x, i, j, l, ll, selElmnt, a, b, c, insideEl;
    /* Look for any elements with the class "custom-select": */
    x = document.getElementsByClassName("color-select");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /* For each element, create a new DIV that will act as the selected item: */
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        var placeholder = document.createTextNode(selElmnt.options[selElmnt.selectedIndex].innerHTML)
        var placeholderWrapper = document.createElement("DIV");
        placeholderWrapper.appendChild(placeholder)
        a.appendChild(placeholderWrapper)
        x[i].appendChild(a);
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
            /* For each option in the original select element,
        create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            insideEl = document.createElement("DIV");
            insideEl.setAttribute("class", "inside_content");
            insideEl.classList.add('model_' + c.innerText.split(' ').join('').trim());
            c.appendChild(insideEl)
            c.addEventListener("click", function (e) {
                /* When an item is clicked, update the original select box,
            and the selected item: */
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                var copySelected = this.parentNode.parentNode.getElementsByClassName("select-selected")[0]
                copySelected.innerHTML = this.innerHTML
                $(copySelected).wrapInner('<div></div>')
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function (e) {
            /* When the select box is clicked, close any other select boxes,
        and open/close the current select box: */
            if (selectOpened) {
                if (blurBox.classList.contains('active')) {
                    blurBox.classList.remove('active');
                }
                if (body.classList.contains('noScroll')) {
                    body.classList.remove('noScroll');
                }
                selectOpened = false
                return;
            }
            selectOpened = true
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
            blurBox.classList.toggle('active');
            body.classList.toggle('noScroll');
        });
    }

    function closeAllSelect(elmnt) {
        /* A function that will close all select boxes in the document,
        except the current select box: */
        var x, y, i, xl, yl, arrNo = [], selects, z;
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
                blurBox.classList.remove('active');
                body.classList.remove('noScroll');
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
                blurBox.classList.remove('active');
                body.classList.remove('noScroll');
            }
        }
    }
}

//Проверяем была ли выбранна модель
$("div#model .select-items div").on("click", function () {
    const r = document.createRange();
    r.selectNode(this);
    changeSelectColor(r);
});

//выбираем из массива нужный нам цвет и изменяем список
function changeSelectColor(model_select) {
    $('.color-select select').find('option').remove(); //удаление старых данных
    $('div#color .select-selected').remove();
    $('div#color .select-items.select-hide').remove();
    // alert(model_select);
    const iphone = {
        "iPhone XR": ["RED", "Yellow", "White", "Coral", "Black", "Blue"],
        "iPhone SE (2nd generation)": ["Gold", "Silver", "Space Gray", "Rose Gold"],
        "iPhone 11 Pro Max": ["Midnight Green", "Space Grey", "Silver", "Gold"],
        "iPhone 11 Pro": ["Midnight Green", "Space Grey", "Silver", "Gold"],
        "iPhone 11": ["Midnight Green", "Space Grey", "Silver", "Gold"],
        "iPhone XS Max": ["Space Grey", "Silver", "Gold"],
        "iPhone XS": ["Space Grey", "Silver", "Gold"],
        "iPhone X": ["RED", "Yellow", "White", "Coral", "Black", "Blue"],
        "iPhone 8 Plus": ["Gold", "Red", "Silver", "Space Gray"],
        "iPhone 8": ["Gold", "Red", "Silver", "Space Gray"],
        "iPhone 7 Plus": ["Rose Gold", "Gold", "Silver", "Black", "Jet Black or the Special Edition PRODUCT(RED)"],
        "iPhone 7": ["Rose Gold", "Gold", "Silver", "Black", "Jet Black or the Special Edition PRODUCT(RED)"],
        "iPhone SE (1nd generation)": ["Gold", "Silver", "Space Gray", "Rose Gold"],
        "iPhone 6s Plus": ["Gold", "Silver", "Space Gray", "Rose Gold"],
        "iPhone 6s": ["Gold", "Silver", "Space Gray", "Rose Gold"],
        "iPhone 6 Plus": ["Space Grey", "Silver", "Gold"],
        "iPhone 6": ["Space Grey", "Silver", "Gold"],
        "iPhone 5s": ["Space Grey", "Silver", "Gold"],
        "iPhone 5c": ["Blue", "Green", "Pink", "White", "Yellow"],
        "iPhone 5": ["Black", "White"],
        "iPhone 4S": ["Black", "White"],
        "iPhone 4": ["Black", "White"],
        "iPhone 3GS": ["Black", "White"],
        "iPhone 3G": ["Black", "White"],
        "iPhone model:": ["Space Grey", "Silver", "Gold"]
    };
    var iphoneColor = iphone[model_select];
    console.log(iphone);

    iphoneColor.forEach(myFunction);

    function myFunction(item, index) {
        var s = document.querySelector('.color-select select').options;
        s[s.length] = new Option(item, item, true);
        // document.getElementById("div#color select").innerHTML += index + ":" + item + "<br>";
    }


    createCustomColorSelect();
}

})
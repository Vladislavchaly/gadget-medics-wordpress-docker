jQuery(document).ready( function() {
  var regPhone = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;
  var regEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i
  var formData = new FormData()

document.addEventListener('scroll', scrollItem)

function scrollItem () {
  const item = document.getElementsByClassName('iphone_moving_pic')[0]
  let scrollFrom = 422
  if (document.documentElement.clientWidth <= 1300) {
    scrollFrom = 221
  }
  if (document.documentElement.clientWidth <= 768) {
    scrollFrom = 350
  }
  const value = document.documentElement.scrollTop - scrollFrom
  item.style.bottom = value + 'px'
}

var blurBox = document.getElementsByClassName('blurBg-select')[0]
var body = document.body
var selectOpened = false

var x, i, j, l, ll, selElmnt, a, b, c, insideEl;
/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("custom-select");
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
    c.addEventListener("click", function(e) {
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
  a.addEventListener("click", function(e) {
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

/* If the user clicks anywhere outside the select box,
then close all select boxes: */
document.addEventListener("click", closeAllSelect);

  var popupPayment = document.getElementsByClassName('payment_layout')[0]
  var popupSuccess = document.getElementsByClassName('success_layout')[0]
  var closePayment = document.getElementById('closePayment')
  var closeSuccess = document.getElementById('closeSuccess')
  var btnForm = document.getElementById('mainFormInfo')
  var mainForm = document.getElementById('mainForm')
  var paymentBtn = document.getElementsByClassName('paymentSend')

  btnForm.addEventListener("click", function (e) {
    e.preventDefault()
    cleanFormDataFields()
    var errors = ''
    var phone = document.querySelector('#phone').value
    var email
    if (document.documentElement.clientWidth <= 768) {
      email = document.querySelector('#mobile_email').value
    } else {
      email = document.querySelector('#desktop_email').value
    }
    if (phone === '' && !regPhone.test(phone).value) {
      errors = 'Phone is incorrect'
    }
    if (email === '' && !regEmail.test(email).value) {
      errors = 'Email is incorrect'
    }
    if (errors === '') {
      $('.repairMainForm .buttonBlock p').text('*when you pay online')
      $('.repairMainForm .buttonBlock p').removeClass('error')
      popupPayment.classList.add('active')
      createFormData()
    } else {
      $('.repairMainForm .buttonBlock p').text(errors)
      $('.repairMainForm .buttonBlock p').addClass('error')
    }
  });

  function cleanFormDataFields () {
    formData.delete('action')
    formData.delete('payment')
    formData.delete('name')
    formData.delete('phone')
    formData.delete('email')
    formData.delete('model')
    formData.delete('color')
  }

  closePayment.addEventListener("click", function (e) {
    e.preventDefault()
    popupPayment.classList.remove('active')
  });

  closeSuccess.addEventListener("click", function (e) {
    e.preventDefault()
    popupSuccess.classList.remove('active')
  });

  for (var i = 0; i < paymentBtn.length; i++) {
    paymentBtn[i].addEventListener("click", function (e) {
      createFormData(e.target.dataset.value)
    })
  }

  function createFormData (payment) {
    var action  = document.querySelector('#action').value
    var name = document.querySelector('#name').value
    var phone = document.querySelector('#phone').value
    var email
    var model = document.getElementById("model").getElementsByClassName('select-selected')[0];
    var color = document.getElementById("color").getElementsByClassName('select-selected')[0];
    if (document.documentElement.clientWidth <= 768) {
      email = document.querySelector('#mobile_email').value
    } else {
      email = document.querySelector('#desktop_email').value
    }
    if (payment) {
      formData.append('payment', payment)
      sentRequest()
    } else {
      formData.append('action', action)
      formData.append('name', name)
      formData.append('phone', phone)
      formData.append('email', email)
      formData.append('model', model.innerText)
      formData.append('color', color.innerText)
    }
  }

  function sentRequest () {
    // jQuery.ajax({
    //   type : "post",
    //   dataType : "json",
    //   url : "/wp-admin/admin-ajax.php",
    //   processData: false,
    //   contentType: false,
    //   data : formData,
    //   // success: function(data, textStatus, xhr) {
    //   //   if(xhr.status == "success") {
    //   //     popupSuccess.classList.add('active')
    //   //   }
    //   //   else {
    //   //     alert("Something was wrong!")
    //   //   }
    //   // },
    //   complete: function(response, textStatus) {
    //     if (response.status === 200) {
    //       alert(response["responseText"]);
    //       console.log(response);
    //       popupSuccess.classList.add('active')
    //       popupPayment.classList.remove('active')
    //     }
    //     else {
    //       alert("Something was wrong!")
    //     }
    //   }
    // })

    jQuery.ajax({
      type : "post",
      url : "/wp-admin/admin-ajax.php",
      processData: false,
      contentType: false,
      data : formData,
      success: function(response) {
        $('#submitpayformajax').html(response);
        popupSuccess.classList.add('active')
        popupPayment.classList.remove('active')
      }
    })
  }
})
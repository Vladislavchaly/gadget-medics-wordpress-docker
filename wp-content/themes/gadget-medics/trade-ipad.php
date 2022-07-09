<?php
/**
 * Template Name: Trade In iPad
 **/
?>
<?php
global $wp_query;
$pageId =  $wp_query->post->ID;
$memoryCustomFields = get_field('memory_iphone',$pageId);
$first = get_field('first',$pageId);
$second = get_field('second',$pageId);
$third = get_field('third',$pageId);
$fourth  = get_field('fourth',$pageId);
$fifth = get_field('fifth',$pageId);
?>
<?php get_header(); ?>
<main class="main">
    <div class="section section__inner">
        <div class="container">
            <div class="section__title">
                <span class="h2">iPad trade-in</span>
            </div>
            <form action="/" id="custom_form1" method="post">
                <div class="trade-form">
                    <div class="trade-form__row cst-active trade-form__row-active">
                        <div class="trade-form__row-title">
                            <span class="trade-form__row-number">1/5.</span>
                            <span class="trade-form__row-step-title">Choose your device:</span>
                            <button class="trade-form__row-button"></button>
                        </div>
                        <div class="trade-form__row-content">
                            <div class="trade-form__checkboxes">
                                <ul class="trade-form__checkboxes-list">
                                    <?php  foreach ($first as $item1) {?>
                                        <li class="trade-form__checkboxes-item">
                                            <label class="checkbox-label">
                                                <input type="radio" class="checkbox-input" name="device" value="<?= $item1['model']?>">
                                                <span class="checkbox-txt"><?= $item1['text']?></span>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <ul class="trade-form__checkboxes-list">
                                    <?php  foreach ($second as $item2) { ?>
                                        <li class="trade-form__checkboxes-item">
                                            <label class="checkbox-label">
                                                <input type="radio" class="checkbox-input" name="device" value="<?= $item2['model']?>">
                                                <span class="checkbox-txt"><?= $item2['text']?></span>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <ul class="trade-form__checkboxes-list">
                                    <?php  foreach ($third as $item3) { ?>
                                        <li class="trade-form__checkboxes-item">
                                            <label class="checkbox-label">
                                                <input type="radio" class="checkbox-input" name="device" value="<?= $item3['model']?>">
                                                <span class="checkbox-txt"><?= $item3['text']?></span>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <ul class="trade-form__checkboxes-list">
                                    <?php  foreach ($fourth as $item4) { ?>
                                        <li class="trade-form__checkboxes-item">
                                            <label class="checkbox-label">
                                                <input type="radio" class="checkbox-input" name="device" value="<?= $item4['model']?>">
                                                <span class="checkbox-txt"><?= $item4['text']?></span>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <ul class="trade-form__checkboxes-list">
                                    <?php  foreach ($fifth as $item5) { ?>
                                        <li class="trade-form__checkboxes-item">
                                            <label class="checkbox-label">
                                                <input type="radio" class="checkbox-input" name="device" value="<?= $item5['model']?>">
                                                <span class="checkbox-txt"><?= $item5['text']?></span>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
<!--                                <ul class="trade-form__checkboxes-list">-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone 5">-->
<!--                                            <span class="checkbox-txt">iPhone <b>5</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone 5c">-->
<!--                                            <span class="checkbox-txt">iPhone <b>5C</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone 5s">-->
<!--                                            <span class="checkbox-txt">iPhone <b>5S</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                                <ul class="trade-form__checkboxes-list">-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone 6">-->
<!--                                            <span class="checkbox-txt">iPhone <b>6</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device"-->
<!--                                                   value="iPhone 6 plus">-->
<!--                                            <span class="checkbox-txt">iPhone <b>6 Plus</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone 6s">-->
<!--                                            <span class="checkbox-txt">iPhone <b>6S</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device"-->
<!--                                                   value="iPhone 6s plus">-->
<!--                                            <span class="checkbox-txt">iPhone <b>6S Plus</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                                <ul class="trade-form__checkboxes-list">-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone 7">-->
<!--                                            <span class="checkbox-txt">iPhone <b>7</b> </span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device"-->
<!--                                                   value="iPhone 7 plus">-->
<!--                                            <span class="checkbox-txt">iPhone <b>7 Plus</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                                <ul class="trade-form__checkboxes-list">-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone 8">-->
<!--                                            <span class="checkbox-txt">iPhone <b>8</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device"-->
<!--                                                   value="iPhone 8 plus">-->
<!--                                            <span class="checkbox-txt">iPhone <b>8 Plus</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                                <ul class="trade-form__checkboxes-list">-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone x">-->
<!--                                            <span class="checkbox-txt">iPhone <b>X</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone xr">-->
<!--                                            <span class="checkbox-txt">iPhone <b>XR</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device" value="iPhone xs">-->
<!--                                            <span class="checkbox-txt">iPhone <b>XS</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                    <li class="trade-form__checkboxes-item">-->
<!--                                        <label class="checkbox-label">-->
<!--                                            <input type="radio" class="checkbox-input" name="device"-->
<!--                                                   value="iPhone xs max">-->
<!--                                            <span class="checkbox-txt">iPhone <b>XS Max</b></span>-->
<!--                                        </label>-->
<!--                                    </li>-->
<!--                                </ul>-->

                            </div>
                        </div>
                    </div>
                    <div class="trade-form__row cst-active trade-form__row-next">
                        <div class="trade-form__row-title">
                            <span class="trade-form__row-number">2/5.</span>
                            <span class="trade-form__row-step-title">Choose your version:</span>
                            <button class="trade-form__row-button"></button>
                        </div>
                        <div class="trade-form__row-content">
                            <ul class="trade-form__checkboxes-row">
                                <li class="trade-form__checkboxes-item">
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input">
                                        <span class="checkbox-txt">Cellular</span>
                                    </label>
                                </li>
                                <li class="trade-form__checkboxes-item">
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input">
                                        <span class="checkbox-txt">WiFi only</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="trade-form__row cst-active trade-form__row-next">
                        <div class="trade-form__row-title">
                            <span class="trade-form__row-number">3/5.</span>
                            <span class="trade-form__row-step-title">Choose your storage</span>
                            <button class="trade-form__row-button"></button>
                        </div>

                        <div class="trade-form__row-content">
                            <ul class="trade-form__checkboxes-row trade-form__checkboxes-row-auto phone-memory-list">
                                <?php foreach ($memoryCustomFields as $item){ ?>
                                    <li class="trade-form__checkboxes-item">
                                    <span class="phone-model" style="display: none">
                                        <?php echo $item['model']?>
                                    </span>
                                        <label class="checkbox-label">
                                            <input type="radio" class="checkbox-input" name="storage" value="<? echo  $item['memory_size'].'GB'?>">
                                            <span class="checkbox-txt"><b><?= $item['memory_size']?></b> GB</span>
                                        </label>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                    </div>
                    <div class="trade-form__row cst-active trade-form__row-next">
                        <div class="trade-form__row-title">
                            <span class="trade-form__row-number">4/5.</span>
                            <span class="trade-form__row-step-title">Let us know more about your device</span>
                            <button class="trade-form__row-button"></button>
                        </div>
                        <div class="trade-form__row-content">
                            <ul class="trade-form__checkboxes-row trade-form__checkboxes-row-questions">
                                <li class="trade-form__checkboxes-item">
                                    <span class="trade-form__checkboxes-item-title">Does the device
<b>power on?</b></span>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="powerOn" value="Yes">
                                        <span class="checkbox-txt">Yes</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="powerOn" value="No">
                                        <span class="checkbox-txt">No</span>
                                    </label>
                                </li>
                                <li class="trade-form__checkboxes-item">
                                    <span class="trade-form__checkboxes-item-title">Does the screen
<b>fully light up?</b></span>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="fullyLightUp" value="Yes">
                                        <span class="checkbox-txt">Yes</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="fullyFunctional" value="No">
                                        <span class="checkbox-txt">No</span>
                                    </label>
                                </li>
                                <li class="trade-form__checkboxes-item">
                                    <span class="trade-form__checkboxes-item-title">Is your device
<b>fully functional?</b></span>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="fullyFunctional" value="Yes" >
                                        <span class="checkbox-txt">Yes</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="fullyFunctional" value="No">
                                        <span class="checkbox-txt">No</span>
                                    </label>
                                </li>
                                <li class="trade-form__checkboxes-item">
                                    <span class="trade-form__checkboxes-item-title">Are there
<b>scratches anywhere?</b></span>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="scratchesAnywhere" value="Yes">
                                        <span class="checkbox-txt">Yes</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="scratchesAnywhere" value="No">
                                        <span class="checkbox-txt">No</span>
                                    </label>
                                </li>
                                <li class="trade-form__checkboxes-item">
                                    <span class="trade-form__checkboxes-item-title">Are there
<b>cracks anywhere?</b></span>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="cracksAnywhere" value="Yes">
                                        <span class="checkbox-txt">Yes</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="radio" class="checkbox-input" name="cracksAnywhere" value="No">
                                        <span class="checkbox-txt">No</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="trade-form__row cst-active trade-form__row-next">
                        <div class="trade-form__row-title">
                            <span class="trade-form__row-number">5/5.</span>
                            <span class="trade-form__row-step-title">One more step to go</span>
                            <button class="trade-form__row-button"></button>
                        </div>
                        <div class="trade-form__row-content">
                            <div class="trade-form__row-form">
                                <div class="trade-form__row-form-group">
                                    <span class="h5">Leave your personal information: </span>
                                    <div class="input-field">
                                        <label class="form-control__label" for="fcName">What is your name?</label>
                                        <input type="text" class="form-control" id="fcName" name="username">
                                    </div>
                                    <div class="input-field">
                                        <label class="form-control__label" for="fcNumber">What is your phone
                                            number?</label>
                                        <input type="text" class="form-control" id="fcNumber" name="phone">
                                    </div>
                                    <div class="input-field">
                                        <label class="form-control__label" for="fcMail">What is your E-mail
                                            address?</label>
                                        <input type="email" class="form-control" id="fcMail" name="e-mail">
                                    </div>
                                </div>
                                <div class="trade-form__row-form-photo">
                                    <span class="h5">Add up to 3 pictures:  <span style="padding-left: 2px"> *Not necessarily</span></span>
                                    <div class="input-field-photo">
                                        <label class="form-control__photo">
                                            <!--                                        <input type="file" name="myfile" id="myfile" multiple="multiple">-->
                                            <input class="form-control-file files-data" type="file" name="myfile"
                                                   id="myfile" multiple="multiple">
                                            <span class="form-control__photo-txt">
                                                <b class="cst-b">Upload</b>
                                            </span>

                                        </label>
                                        <span class="form-control__photo-content" style="display: flex;width: 200px;">
                                           Front | Back | Bottom
                                        </span>
                                    </div>
                                </div>
                                <div class="trade-form__row-form-group-submit">
                                    <input type="submit" class="btn btn-primary" value="Send" id="send-data">
                                    <small>We will be in touch with you in 24-48 hours</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<div id="overlay-custom">
    <div class="lds-ripple"><div></div><div></div></div>
</div>
<style>
    .cst-b{
        margin-right: 0!important;
        margin-left: 4px;
    }
    #overlay-custom{
        display: none;
        width: 100%;
        height: 100vh;
        background-color: rgba(0,0,0,.5);
        position: fixed;
        top: 0;
        left: 0;
        justify-content: center;
        align-items: center;
        z-index: 9999999;
    }
    .swal-modal .swal-text {
        text-align: center;
    }
    .lds-ripple {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }
    .lds-ripple div {
        position: absolute;
        border: 4px solid #fff;
        opacity: 1;
        border-radius: 50%;
        animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }
    .lds-ripple div:nth-child(2) {
        animation-delay: -0.5s;
    }
    @keyframes lds-ripple {
        0% {
            top: 36px;
            left: 36px;
            width: 0;
            height: 0;
            opacity: 1;
        }
        100% {
            top: 0px;
            left: 0px;
            width: 72px;
            height: 72px;
            opacity: 0;
        }
    }

</style>
<?php get_footer(); ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function (n, i) {
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }

    $(document).ready(
        function (e) {
            var form = $('#custom_form1');
            form.on('submit', function (e) {
                var loader = document.getElementById('overlay-custom');

                var formOtherData = getFormData(form);
                e.preventDefault();
                console.log(formOtherData);
                var formData = new FormData();
                if (($('#myfile')[0].files).length != 0) {
                    $.each($('#myfile')[0].files, function (i, file) {
                        formData.append("file[" + i + "]", file);
                    });
                    for (let key in formOtherData) {
                        formData.append(key, formOtherData[key]);
                    }
                } else {
                    return false;
                }
                //console.log(Array.from(formData));
                $.ajax({
                    type: "POST",
                    url: "https://gadgetmedics.com/repair-email.php",
                    cache: false,
                    // dataType:"json",
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function () {
                        loader.style.display =  'flex';
                        console.log('Запрос начат');
                        form.find('input').prop("disabled", true);
                    },
                    success: function (data) {
                        console.log('А тут отработать если ок');
                        loader.style.display =  'none';
                        swal({
                            html: true,
                            icon: "success",
                            title: "Thank you for your request",
                            text: "One of our representative will get back to you in 24 hours or less ",
                            confirm: {
                                text: "OK",
                                value: true,
                                visible: true,
                                className: "",
                                closeModal: true
                            }
                        }).catch(swal.noop).then(function (result) {
                            window.location.href = "/";
                        });
                        if (data.status == 'ok') {
                            $('#myfile').val('');
                        } else {
                            console.log('Что-то не так с загрузкой');
                        }
                    },
                    complete: function (data) {
                        console.log('Запрос закончен');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                    }
                });
                return false;
            });
        }
    );
</script>
<script>
    var count = 0;
    var buttons = document.getElementsByClassName('cst-active');
    let modelsSub = buttons[0];
    let chLabels = modelsSub.getElementsByClassName('checkbox-label');
    for (let i =0; i < chLabels.length; i++){
        chLabels[i].addEventListener('click',function () {
            let val = this.getElementsByTagName('input')[0];
            var phoneModel = val.value;
            var memoryListGet = document.getElementsByClassName('phone-memory-list')[0];
            var memoryListItemGet = memoryListGet.getElementsByTagName('li');
            for (let h=0;h<memoryListItemGet.length;h++){
                var getSize = memoryListItemGet[h].getElementsByClassName('phone-model')[0];
                var memoryText = getSize.innerText.trim();
                let modelsArr = memoryText.split('/');
                let found = false;
                for(let x = 0; x < modelsArr.length; x++){
                    console.log(modelsArr[x]+"_____"+phoneModel+"___"+(modelsArr[x]==phoneModel));
                    console.log(memoryListItemGet[h]);
                    if(!found){
                        if(modelsArr[x].trim() == phoneModel.trim()){
                            found = true;
                            memoryListItemGet[h].style.display = "block";
                        }else{
                            memoryListItemGet[h].style.display = "none";
                        }
                    }
                }
            }
        });
    }
    for (let k = 0; k < buttons.length; k++) {
        buttons[k].addEventListener("click", function () {
            var removeActive = document.getElementsByClassName('trade-form__row-active')[0];
            var filled  = document.getElementsByClassName('trade-form__row-filled')[0];
            var insertAftherBlock = removeActive.getElementsByClassName('trade-form__row-number')[0];
            var inpValue = removeActive.getElementsByTagName('input');
            var memoryListGet = document.getElementsByClassName('phone-memory-list')[0];
            var memoryListItemGet = memoryListGet.getElementsByTagName('li');
            var isChecked = false;
            for (let j = 0; j < inpValue.length; j++) {
                // var checkedInput =  inpValue[j].getElementsByTagName('input')[0];
                if (inpValue[j].checked === true) {
                    isChecked = true;
                    var checkedInputValue = inpValue[j].value;
                    let val = removeActive.getElementsByClassName('trade-form__row-step-value');
                    if (val[0]){
                        val[0].parentElement.removeChild(val[0]);
                    }
                    $('<span class="trade-form__row-step-value">' + checkedInputValue + '</span>').insertAfter(insertAftherBlock);
                }
            }
            let parent = this;
            // if (parent.classList.contains('filled')){
            if (isChecked) {
                removeActive.classList.remove('trade-form__row-active');
                removeActive.classList.add('trade-form__row-filled');
                removeActive.classList.add('trade-form__row-next');
                parent.classList.remove("trade-form__row-next");
                parent.classList.remove("trade-form__row-filled");
                parent.classList.add("trade-form__row-active");
            }
            // }else{
            //
            // }
            //
            //
            // removeActive.classList.remove("trade-form__row-active");
            // // filled.classList.remove("trade-form__row-filled");
            // removeActive.classList.add("trade-form__row-next");
            // removeActive.classList.add("trade-form__row-filled");
            // // this.addClass('trade-form__row-active');
            // this.parentElement.parentElement.classList.remove("trade-form__row-next");
            // this.parentElement.parentElement.classList.add("trade-form__row-active");
            // this.parentElement.parentElement.classList.remove("trade-form__row-filled");
        });
    }
    // var sendBtn = document.getElementById('send-data');
    // sendBtn.addEventListener("click", function(event){
    //     event.preventDefault();
    //     var formData = $('#custom_form');
    //     var dataFormArray = getFormData(formData);
    //     var form_data = new FormData(formData);
    //
    //     // Read selected files
    //     var totalfiles = document.getElementById('file').files.length;
    //     for (var index = 0; index < totalfiles; index++) {
    //         form_data.append("files[]", document.getElementById('file').files[index]);
    //     }
    //     console.log(form_data);

    //  });
    //$(document).on("click",".trade-form__row-button",function(e) {
    // e.preventDefault();
    // alert("The paragraph was clicked.");
    // console.log(this.parentElement.parentElement.nextElementSibling);
    // this.parentElement.parentElement.nextElementSibling.switchClass('trade-form__row-next','trade-form__row-active');
    //});
</script>



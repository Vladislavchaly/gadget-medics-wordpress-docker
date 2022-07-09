<?php

/*

Template Name: Business card

*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title>Gadgetmedics.com</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<?php $id_page=get_the_ID();?>
<link rel="stylesheet" href="https://gadgetmedics.com/wp-content/themes/gadget-medics/css/business-card.css">
<link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main">


            <div class="headerPart">
                <div class="bgCircle"></div>
                <div class="headerInfo">
                    <img src="<?php echo get_field('image', $id_page); ?>" alt="Vadim boyko">
                    <p><strong><?php echo get_field('name', $id_page); ?></strong></p>
                    <p><?php echo get_field('post', $id_page); ?></p>

                </div>
                <div class="headerActions">
                    <div>
                        <a href="tel:<?php echo get_field('phone_link', $id_page); ?>">
                            <div class="circle"><img src="/wp-content/themes/gadget-medics/img/business-card/phone.svg" alt="Phone"></div>
                            <p>Call</p>
                        </a>
                    </div>
                    <div>
                        <a href="mailto:<?php echo get_field('email', $id_page); ?>">
                            <div class="circle"><img src="/wp-content/themes/gadget-medics/img/business-card/mail.svg" alt="Mail"></div>
                            <p>Email</p>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo get_field('map_link', $id_page); ?>" target="_blank">
                            <div class="circle"><img src="/wp-content/themes/gadget-medics/img/business-card/map.svg" alt="Map"></div>
                            <p>Map</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="bodyPart">
                <div class="bodyItem">
                    <a href="tel:<?php echo get_field('phone_link', $id_page); ?>">
                        <div class="circle colorful"><img src="/wp-content/themes/gadget-medics/img/business-card/phone.svg" alt="Phone "></div>
                        <div class="number">
                            <p><strong><?php echo get_field('phone', $id_page); ?></strong></p>
                            <p>Telephone</p>
                        </div>
                    </a>
                </div>
                <div class="bodyItem">
                    <a href="mailto:<?php echo get_field('email', $id_page); ?>">
                        <div class="circle colorful"><img src="/wp-content/themes/gadget-medics/img/business-card/mail.svg" alt="Mail "></div>
                        <div class="number">
                            <p><strong><?php echo get_field('email', $id_page); ?></strong></p>
                            <p>Email</p>
                        </div>
                    </a>
                </div>
                <div class="bodyItem">
                    <div class="circle colorful"><img src="/wp-content/themes/gadget-medics/img/business-card/bag.svg" alt="Bag "></div>
                    <div class="number">
                        <p><strong><?php echo get_field('company_name', $id_page); ?></strong></p>
                        <p><?php echo get_field('company_name_subtitle', $id_page); ?></p>
                    </div>
                </div>
                <div class="bodyItem">
                    <div><div class="circle colorful"><img src="/wp-content/themes/gadget-medics/img/business-card/map.svg" alt="Map "></div></div>
                    <div class="number">
                        <p><strong><?php echo get_field('address', $id_page); ?></strong></p>
                        <a target="_blank" href="<?php echo get_field('map_link', $id_page); ?>" class="redcolor"><strong>Show on map</strong></a>
                    </div>
                </div>
                <div class="bodyItem mb0">
                    <a href="<?php echo get_field('link_website', $id_page); ?>">
                    <div class="circle colorful"><img src="/wp-content/themes/gadget-medics/img/business-card/world.svg" alt="World "></div>
                    <div class="number">
                        <p><strong><?php echo get_field('link_website', $id_page); ?></strong></p>
                        <p>Website</p>
                    </div>
                    </a>
                </div>
            </div>
            <div class="social">
                <h3>Social Media:</h3>
                <div class="socialMedia">
                    <a href="<?php echo get_field('facebook_link', $id_page); ?>">
                        <div class="circleFacebook circle"><img src="/wp-content/themes/gadget-medics/img/business-card/facebook.svg" alt="Facebook"></div>
                    </a>
                    <a href="<?php echo get_field('Instagram_link', $id_page); ?>">
                        <div class="circleInstagram circle"><img src="/wp-content/themes/gadget-medics/img/business-card/insta.svg" alt='Instagram'></div>
                    </a>
                </div>
                <div class="buttons">
                    <div class="btn btn-primary" onclick="handleModalProfile()">
                        <img src="/wp-content/themes/gadget-medics/img/business-card/share+.svg" alt="profile">
                    </div>
                    <div class="btn btn-danger" onclick="handleModalShare()">
                        <img src="/wp-content/themes/gadget-medics/img/business-card/share.svg" alt="share">
                    </div>
                </div>
            </div>
            <div class="modal handlerModalProfile">
                <div class="title">
                    <h5><strong>How would you like to save contact data?</strong></h5>
                    <span onclick="handleModalProfile()"></span>
                </div>
                <ul>
                    <li>
                        <a href="mailto:?body=https://gadgetmedics.com/business-card">
                            <img src="/wp-content/themes/gadget-medics/img/business-card/modal/Email2.0.svg" alt="send by email">
                            <p>Send by email</p>
                        </a>
                    </li>
                    <li>
                        <a href="/wp-content/themes/gadget-medics/img/vcard_vadim_boyko.vcf">
                            <img src="/wp-content/themes/gadget-medics/img/business-card/modal/SavePhone.svg" alt="save to My phone">
                            <p>Save to My phone</p>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="modal handlerModalShare">
                <div class="title">
                    <h5><strong>Share</strong></h5>
                    <span onclick="handleModalShare()"></span>
                </div>
                <ul>
                    <li>
                        <a target="_blank" href="https://www.facebook.com/share.php?u=https%3A%2F%2Fgadgetmedics.com%2Fbusiness-card">
                            <img src="/wp-content/themes/gadget-medics/img/business-card/modal/facebook.svg" alt="facebook">
                            <p>Facebook</p>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="https://twitter.com/intent/tweet?url=https%3A%2F%2Fgadgetmedics.com%2Fbusiness-card&text=gadgetmedics">
                            <img src="/wp-content/themes/gadget-medics/img/business-card/modal/twitter.svg" alt="twitter">
                            <p>Twitter</p>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="whatsapp://send?text=https://gadgetmedics.com/business-card/">
                            <img src="/wp-content/themes/gadget-medics/img/business-card/modal/Whatsapp.svg" alt="whatsapp">
                            <p>Whatsapp</p>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:?body=https://gadgetmedics.com/business-card">
                            <img src="/wp-content/themes/gadget-medics/img/business-card/modal/Email.svg" alt="email">
                            <p>Email</p>
                        </a>
                    </li>
                </ul>
            </div>

    </main>
    <script>
        function handleModalProfile() {
            var modal = document.querySelector('.handlerModalProfile')
            if (modal.classList.contains('active')) {
                modal.classList.remove('active')
            } else {
                modal.classList.add('active')
            }
        }

        function handleModalShare() {
            var modal = document.querySelector('.handlerModalShare')
            if (modal.classList.contains('active')) {
                modal.classList.remove('active')
            } else {
                modal.classList.add('active')
            }
        }
    </script>
</body>

</html>
    <?php //get_footer(); ?>



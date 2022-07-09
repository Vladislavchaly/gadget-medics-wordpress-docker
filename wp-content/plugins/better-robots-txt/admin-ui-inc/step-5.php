<h3><?php echo __( 'STEP', 'better-robots-txt' ) . " 5 - " . __( 'PERSONALIZE YOUR ROBOTS.TXT:', 'better-robots-txt' ); ?></h3>
            
<div class="rt-row">

    <div class="rt-column col-3">
        <span class="rt-label"><?php echo __( 'Be unique', 'better-robots-txt' ); ?></span>
    </div>
    
    <div class="rt-column col-8">
        <textarea name="personalize" rows="4" class="rt-area" id="personalize"><?php if(isset($options['personalize']) && !empty($options['personalize'])) echo stripslashes($options['personalize']); ?></textarea>
        <div class="rt-alert rt-warning">
            <span class="closebtn">&times;</span> 
            <?php echo __( 'Create a unique signature like:', 'better-robots-txt' ); ?> <a href="https://store.nike.com/robots.txt" target="_blank">NIKE</a>, <a href="https://www.tripadvisor.com/robots.txt" target="_blank">TRIPADVISOR</a>, <a href="https://www.youtube.com/robots.txt" target="_blank">YOUTUBE</a>, <a href="https://www.yelp.com/robots.txt" target="_blank">YELP</a>
        </div>
    </div>
    
</div>

<div class="rt-row">
<p style="margin-left: 240px; font-size: 13px; line-height: 80%; padding: 0; margin-bottom: 0"><?php echo sprintf( wp_kses( __( 'This feature will add a message of hope in your robots.txt for all mankind (like <a href="%s" target="_blank">this</a>)', 'better-robots-txt' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( plugin_dir_url( __FILE__ ) . '../assets/imgs/corona.jpg' ) ); ?></p>

<div class="rt-column col-3">
    <span class="rt-label"><?php 
echo  __( 'Be part of our Movement against CoronaVirus', 'better-robots-txt' ) ;
?></span>
</div>

<div class="rt-column col-8">

<label class="rt-switch rt-boost-label">
    <input type="checkbox" id="covid-19" name="covid-19" value="allow" <?php if ( isset($options['covid-19']) && !empty($options['covid-19']) ) { echo  'checked="checked"'; } ?> />
    <span class="rt-slider rt-round"></span>
</label>

    &nbsp; <span><?php 
echo  __( 'Disallow CoronaVirus (Covid-19) from exploring the world and infecting humanity.', 'better-robots-txt' ) ;
?></span>

</div>

</div>

<hr>
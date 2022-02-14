<?php 
  get_header(); 
  
  $page_settings = get_post_meta($post->ID);

  $section_title = "";
  $section_subtitle = "";
  $section_className = "";
  $section_id = "";

  if($page_settings){
    $section_title = array_pop($page_settings['section_title']);
    $section_subtitle = array_pop($page_settings['section_subtitle']);
    $section_className = array_pop($page_settings['section_className']);
    $section_id = array_pop($page_settings['section_id']);
  }

?>

  <main>
    <section class="<?= $section_className; ?>" id="<?= $section_id; ?>">
        
      <div class="text-center">
      <?php 
        if($section_title){
          echo '<h2 class="pb-2">'.$section_title.'</h2>';
        }
        if($section_subtitle){
          echo '<p class="pb-2">'.$section_subtitle.'</p>';
        }
      ?>
      </div>
      <?php 
        the_content();
      ?>
    </section>
  </main>

<?php 
get_footer(); 

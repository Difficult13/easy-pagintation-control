<?php
if ( ! defined( 'ABSPATH' ) ) {
    die;
}
?>

<input
    class="small-text"
    type="number"
    step="1"
    min="0"
    id="<?php esc_attr($args['id']); ?>"
    name="<?php echo esc_attr($args['name']); ?>"
    value="<?php echo esc_attr($args['value']); ?>"
/>
<?php esc_html_e('elements', 'easy-pagination-control') ?>
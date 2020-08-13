<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Easy Pagination Control
 * @subpackage Easy Pagination Control/admin/partials
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}
?>
<div class="wrap">

    <div class="epc-container" id="epc-body">
        <h1><?php esc_html_e('Easy Pagination Control', 'easy-pagination-control') ?></h1>

        <?php $success_message = __('Настройки успешно сохранены', 'easy-pagination-control'); ?>
        <div id="epc-notice-success" hidden class="notice notice-success"> <p><?php echo esc_html($success_message); ?></p></div>

        <?php $error_message = __('Произошла ошибка. Попробуйте еще раз.', 'easy-pagination-control'); ?>
        <div id="epc-notice-error" hidden class="notice notice-error"> <p><?php echo esc_html($error_message); ?></p></div>

        <p class="epc-tooltip">
            <?php esc_html_e('Введите число нужного количества элементов на странице напротив соответствующей сущности и нажмите кнопку "Сохранить изменения"', 'easy-pagination-control') ?>
        </p>
        <p class="epc-tooltip">
            <strong><?php esc_html_e('Примечание.', 'easy-pagination-control') ?></strong> <?php esc_html_e('Значение "0" означает, что применяются стандартные настройки WP', 'easy-pagination-control') ?>
        </p>
        <hr>
        <form id="epc-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
            <div class="epc-options">

                <?php
                foreach ($data as $section_name => $section) {
                    if (empty($section['entities'])){
                        continue;
                    }
                    ?>

                    <div class="epc-options-section" id='<?php echo esc_attr($section_name); ?>'>
                        <h2><?php echo esc_html($section['type_name']); ?></h2>
                        <table class="form-table">
                            <tbody>
                            <?php
                            foreach ($section['entities'] as $entity_name => $row) {
                                ?>
                                <tr>
                                    <td>
                                        <label for="<?php echo esc_attr($entity_name) ?>"><?php echo esc_html($row['name']); ?></label>
                                    </td>
                                    <td>
                                        <input type="number" step="1" min="0" class="small-text epc-number-input"
                                               id="<?php echo esc_attr($entity_name) ?>" name="<?php echo esc_attr($entity_name) ?>" value="<?php echo esc_attr($row['count']); ?>" required>
                                        <span> <?php esc_html_e('элементов на странице', 'easy-pagination-control') ?></span>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <?php
                }
                ?>
                <input type="hidden" name="action" value="epc_post">
                <input type="hidden" name="epc_nonce" id="epc_nonce" value="<?php echo wp_create_nonce('epc_option_nonce'); ?>">
                <button id="epc-submit" type="submit" class="button button-primary epc-submit"><?php esc_html_e('Сохранить изменения', 'easy-pagination-control') ?></button>
            </div>
        </form>
    </div>
</div>
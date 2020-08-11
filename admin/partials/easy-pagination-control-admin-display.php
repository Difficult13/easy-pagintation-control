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
        <h1><?php _e('Easy Pagination Control', 'easy-pagination-control') ?></h1>

        <?php $success_message = __('Настройки успешно сохранены', 'easy-pagination-control'); ?>
        <div id="epc-notice-success" hidden class="notice notice-success"> <p><?= $success_message ?></p></div>

        <?php $error_message = __('Произошла ошибка. Попробуйте еще раз.', 'easy-pagination-control'); ?>
        <div id="epc-notice-error" hidden class="notice notice-error"> <p><?= $error_message ?></p></div>

        <p class="epc-tooltip">
            <?php _e('Введите число нужного количества элементов на странице напротив соответствующей сущности и нажмите кнопку "Сохранить изменения"', 'easy-pagination-control') ?>
        </p>
        <p class="epc-tooltip">
            <strong><?php _e('Примечание.', 'easy-pagination-control') ?></strong> <?php _e('Значение "0" означает, что применяются стандартные настройки WP', 'easy-pagination-control') ?>
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

                    <div class="epc-options-section" id='<?= $section_name ?>'>
                        <h2><?= $section['type_name'] ?></h2>
                        <table class="form-table">
                            <tbody>
                            <?php
                            foreach ($section['entities'] as $entity_name => $row) {
                                ?>
                                <tr>
                                    <td>
                                        <label for="<?= $entity_name ?>"><?= $row['name'] ?></label>
                                    </td>
                                    <td>
                                        <input type="number" step="1" min="0" class="small-text epc-number-input"
                                               id="<?= $entity_name ?>" name="<?= $entity_name ?>" value="<?= $row['count'] ?>">
                                        <span> <?php _e('элементов на странице', 'easy-pagination-control') ?></span>
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
                <button id="epc-submit" type="submit" class="button button-primary epc-submit"><?php _e('Сохранить изменения', 'easy-pagination-control') ?></button>
            </div>
        </form>
    </div>
</div>
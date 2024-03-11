<?php
/**
 * Testimonial Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$stats            = get_field( 'stats' );

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'stats';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

?>

<div <?php echo esc_attr( $anchor ); ?>class="<?php echo esc_attr( $class_name ); ?>">
    <?php if ( $stats ) : ?>
        <?php foreach ( $stats as $stat ) : ?>
            <div class="stats__col">
                <div class="stats__stat"><?php echo esc_html( $stat['stat'] ); ?></div>
                <div class="stats__desc"><?php echo esc_html( $stat['description'] ); ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
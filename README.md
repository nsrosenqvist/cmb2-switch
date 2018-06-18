CMB2 Switch Field
====================

A boolean switch field type for CMB2.

```php
$analytics = new_cmb2_box(array(
    'id'            => 'analytics',
    'title'         => __('Analytics', 'theme'),
));

$analytics_state = $analytics->add_field(array(
    'name' => __( 'Enable Analytics?', 'theme'),
    'id'   => 'analytics_state',
    'type'    => 'switch',
    'default' => cmb2_set_switch_default(true),
));
```

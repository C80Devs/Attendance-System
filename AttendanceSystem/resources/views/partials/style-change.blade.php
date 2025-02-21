@php

    use App\Models\SettingsModel;$settings = SettingsModel::first();

    $colorLight = (!empty($settings) && !empty($settings->color))
                    ? $settings->color
                    : '#B44545';

    $colorDark  = (!empty($settings) && !empty($settings->color_dark))
                    ? $settings->color_dark
                    : '#A30000';
@endphp


<style>
    :root {
        --primaryColor: {{ $colorLight }};
        --primaryColorDark: {{ $colorDark }};
    }
</style>

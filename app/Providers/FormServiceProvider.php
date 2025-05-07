<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\View\Components\CheckboxField;
use App\View\Components\FieldWrapper;
use App\View\Components\FileField;
use App\View\Components\Label;
use App\View\Components\SelectField;
use App\View\Components\SubmitButton;
use App\View\Components\TextareaField;
use App\View\Components\TextField;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component(TextField::class, 'sendportal.text-field');
        Blade::component(TextareaField::class, 'sendportal.textarea-field');
        Blade::component(FileField::class, 'sendportal.file-field');
        Blade::component(SelectField::class, 'sendportal.select-field');
        Blade::component(CheckboxField::class, 'sendportal.checkbox-field');
        Blade::component(Label::class, 'sendportal.label');
        Blade::component(SubmitButton::class, 'sendportal.submit-button');
        Blade::component(FieldWrapper::class, 'sendportal.field-wrapper');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}

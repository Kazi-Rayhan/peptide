<?php

namespace App\Filament\Pages\Settings;

use App\Models\ShippingMethod;
use Closure;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;

class StoreSettings extends BaseSettings

{
    protected static ?string $navigationLabel = 'Store Settings';
    protected static ?string $title = 'Store Settings';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationIcon = '';

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Settings')
                ->schema([
                    Tabs\Tab::make('General')
                        ->schema([
                            Section::make('Shipping Settings')
                                ->description('Shipping settings for your store.')
                                ->schema([
                                    Select::make('shipping_method_id')
                                        ->label('Shipping Method')
                                        ->options(ShippingMethod::all()->pluck('name', 'id'))
                                        ->helperText('The shipping method for your store.'),
                                ]),
                            Section::make('Store Information')
                                ->description('Basic information about your store.')
                                ->schema([
                                    TextInput::make('store.name')
                                        ->label('Store Name')
                                        ->required()
                                        ->helperText('The name of your ecommerce store.'),
                                    TextInput::make('store.email')
                                        ->label('Contact Email')
                                        ->email()
                                        ->helperText('Customer support or contact email.'),
                                    TextInput::make('store.phone')
                                        ->label('Contact Phone')
                                        ->helperText('Customer support phone number.'),
                                    Textarea::make('store.address')
                                        ->label('Store Address')
                                        ->helperText('Physicaimage.pngl address of your store (for invoices, shipping, etc).'),
                                    \Filament\Forms\Components\FileUpload::make('store.logo')
                                        ->label('Shop Logo')
                                        ->image()
                                        ->directory('settings/logo')
                                        ->helperText('Upload your shop logo (shown in header, emails, etc).'),
                                    \Filament\Forms\Components\FileUpload::make('store.footer_logo')
                                        ->label('Footer Logo')
                                        ->image()
                                        ->directory('settings/footer_logo')
                                        ->helperText('Upload your footer logo (shown in footer).'),
                                    \Filament\Forms\Components\FileUpload::make('store.favicon')
                                        ->label('Favicon')
                                        ->image()
                                        ->directory('settings/favicon')
                                        ->helperText('Upload your favicon (browser tab icon).'),
                                    TextInput::make('store.facebook')
                                        ->label('Facebook Page URL')
                                        ->helperText('Link to your Facebook page.'),
                                    TextInput::make('store.instagram')
                                        ->label('Instagram Profile URL')
                                        ->helperText('Link to your Instagram profile.'),
                                    TextInput::make('store.twitter')
                                        ->label('Twitter Profile URL')
                                        ->helperText('Link to your Twitter/X profile.'),
                                    // TextInput::make('store.currency')
                                    //     ->label('Store Currency')
                                    //     ->default('USD')
                                    //     ->helperText('The default currency for your store (e.g., USD, EUR, GBP).'),
                                ]),
                        ]),
                    Tabs\Tab::make('SEO')
                        ->schema([
                            Section::make('SEO Information')
                                ->description('Meta tags and SEO settings for your shop.')
                                ->schema([
                                    TextInput::make('seo.meta_title')
                                        ->label('Meta Title')
                                        ->maxLength(255)
                                        ->helperText('Title for search engines and browser tabs.'),
                                    Textarea::make('seo.meta_description')
                                        ->label('Meta Description')
                                        ->maxLength(255)
                                        ->helperText('Description for search engines.'),
                                    TextInput::make('seo.meta_keywords')
                                        ->label('Meta Keywords')
                                        ->maxLength(255)
                                        ->helperText('Comma-separated keywords for SEO.'),
                                    TextInput::make('seo.google_analytics_id')
                                        ->label('Google Analytics ID')
                                        ->helperText('Your Google Analytics Measurement ID (e.g., G-XXXXXXXXXX).'),
                                    TextInput::make('seo.facebook_pixel_id')
                                        ->label('Facebook Pixel ID')
                                        ->helperText('Your Facebook Pixel ID for tracking conversions.'),
                                ]),
                        ]),
                    Tabs\Tab::make('Payments')
                        ->schema([
                            Section::make('Payment Methods')
                                ->description('Enable or disable payment methods for your store.')
                                ->schema([
                                    Toggle::make('payments.enable_stripe')
                                        ->label('Enable Stripe')
                                        ->helperText('Allow customers to pay using Stripe.'),
                                    Toggle::make('payments.stripe_sandbox')
                                        ->label('Enable Sandbox')
                                        ->helperText('Enable Stripe Sandbox Mode.'),
                                    TextInput::make('payments.stripe_key')
                                        ->label('Stripe Public Key')
                                        ->helperText('Your Stripe publishable key.'),
                                    TextInput::make('payments.stripe_secret')
                                        ->label('Stripe Secret Key')
                             
                                        ->helperText('Your Stripe secret key.'),
                                    Toggle::make('payments.enable_paypal')
                                        ->label('Enable PayPal')
                                        ->helperText('Allow customers to pay using PayPal.'),
                                    Toggle::make('payments.paypal_sandbox')
                                        ->label('Enable Sandbox')
                                        ->helperText('Enable PayPal Sandbox Mode.'),
                                    TextInput::make('payments.paypal_client_id')
                                        ->label('PayPal Client ID')
                                        ->helperText('Your PayPal client ID.'),
                                    TextInput::make('payments.paypal_secret')
                                        ->label('PayPal Secret')
                                        
                                        ->helperText('Your PayPal secret.'),
                                ]),
                        ]),
                 
                   
                ]),
        ];
    }


} 
# Gravity Forms to FluentCRM Integration

This PHP snippet enables automatic synchronization of form submissions from Gravity Forms to FluentCRM. When a user submits a form, their details are added or updated in a FluentCRM contact list.

## Prerequisites

- WordPress website with Gravity Forms and FluentCRM (free version is sufficient) installed and activated.
- Basic understanding of PHP and WordPress hooks.

## Installation

1. **Locate Your Form and Field IDs:**
   - In your WordPress dashboard, navigate to Gravity Forms and note the ID of the form you want to integrate.
   - Identify the IDs of the fields for 'Name' and 'Email' in your Gravity Forms form.

2. **Edit the PHP Snippet:**
   - Open the PHP file or copy the code provided below.
   - Replace `'name_field_id'` and `'email_field_id'` with the actual field IDs from your form.
   - Replace `'1'` in `add_action` and `'lists'` array with your Gravity Form ID and FluentCRM list ID, respectively.

3. **Add the Code to Your WordPress Site:**
   - Add the edited code to your theme's `functions.php` file or a custom plugin.

## Code Snippet

```php
// Hook into Gravity Forms submission for a specific form. Replace '1' with your form ID.

add_action( 'gform_after_submission_1', 'add_subscriber_to_fluentcrm', 10, 2 );

function add_subscriber_to_fluentcrm( $entry, $form ) {
    // Initialize the FluentCRM API for managing contacts. This creates an instance
    // for interacting with the contacts module in FluentCRM.
    $contactApi = FluentCrmApi('contacts');

    $full_name = rgar( $entry, 'name_field_id' ); // Replace 'name_field_id' with your field ID
    $email = rgar( $entry, 'email_field_id' ); // Replace 'email_field_id' with your field ID

    $name_parts = explode(' ', $full_name);
    $first_name = $name_parts[0];
    $last_name = count($name_parts) > 1 ? implode(' ', array_slice($name_parts, 1)) : '';

    $data = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'status' => 'subscribed',
        'lists' => [1] // Replace '1' with your FluentCRM list ID
    ];

    $contact = $contactApi->createOrUpdate($data);
}

```

## Notes

- Test the integration in a staging environment before applying it to a live website.
- Ensure compliance with data protection regulations when handling user data.
- This script is intended for use with the free version of FluentCRM. Functionality may vary with different versions.

## Contributing

Feel free to fork this repository and submit pull requests or issues if you have suggestions or find bugs.

## License

This script is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

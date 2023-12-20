// Hook into Gravity Forms submission for a specific form. Replace '1' with your form ID.

add_action( 'gform_after_submission_1', 'add_subscriber_to_fluentcrm', 10, 2 );

function add_subscriber_to_fluentcrm( $entry, $form ) {
    // Initialize the FluentCRM API for managing contacts. This creates an instance
    // for interacting with the contacts module in FluentCRM.
    $contactApi = FluentCrmApi('contacts');

    $full_name = rgar( $entry, 'name_field_id' ); // Replace 'name_field_id' with your field ID
    $email = rgar( $entry, 'email_field_id' ); // Replace 'email_field_id' with your field ID

    // Split the full name into an array of words separated by spaces.
   $name_parts = explode(' ', $full_name);
   
   // Assign the first word of the name as the first name.
   $first_name = $name_parts[0];
   
   // If there are more words after the first name, combine them as the last name. 
   // If only one word is present, the last name remains empty.
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

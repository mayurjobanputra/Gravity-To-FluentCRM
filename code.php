/**
 * Gravity Forms submission handler for FluentCRM integration.
 * 
 * This script integrates a specific Gravity Form with FluentCRM. When a form is submitted,
 * it adds or updates the contact in FluentCRM based on the provided name and email.
 */

// Hook into Gravity Forms submission for a specific form. Replace '1' with your form ID.
add_action( 'gform_after_submission_1', 'add_subscriber_to_fluentcrm', 10, 2 );

/**
 * Handles the addition or update of a contact in FluentCRM after a Gravity Form submission.
 * 
 * @param array $entry The form entry data.
 * @param array $form  The form object.
 */
function add_subscriber_to_fluentcrm( $entry, $form ) {
    // Initialize FluentCRM contact API
    $contactApi = FluentCrmApi('contacts');

    // Retrieve name and email from the form entry. Replace 'name_field_id' and 'email_field_id' with actual field IDs.
    $full_name = rgar( $entry, 'name_field_id' );
    $email = rgar( $entry, 'email_field_id' );

    // Splitting the full name into first and last names based on space
    $name_parts = explode(' ', $full_name);
    $first_name = $name_parts[0];
    // If there are more than one word, combine the rest as the last name
    $last_name = count($name_parts) > 1 ? implode(' ', array_slice($name_parts, 1)) : '';

    // Prepare data for FluentCRM
    $data = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email, // Email is required
        'status' => 'subscribed', // Set the status
        'lists' => [1] // Add to a specific list in FluentCRM, replace '1' with your list ID
        // Additional fields can be added here if needed
    ];

    // Create or update the contact in FluentCRM
    $contact = $contactApi->createOrUpdate($data);
}

/**
 * Note: Ensure that this code is tested in a staging environment before deploying to a live site.
 *       Compliance with data protection laws is essential when handling user data.
 */

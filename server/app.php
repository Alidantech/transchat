<?php
$index_page = __DIR__ . '../index.html';

# Read the main.html file
$main_template = __DIR__ . '/templates/main.html';
$main_templateContent = file_get_contents($main_template);

# Check if a page parameter is set, default to 'home' if not provided
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

# Define an array to map pages to their respective template files
$page_templates = [
    'home' => 'home.html',
    'login' => 'login.html',
    'signup' => 'signup.html',
    'chat' => 'chat.html',
];

# Check if the requested page exists in the mapping
if (array_key_exists($page, $page_templates)) {
    # Load the content of the requested template
    $template_file = __DIR__ . '/templates/' . $page_templates[$page];
    if (file_exists($template_file)) {
        $dynamicContent = file_get_contents($template_file);
        
        // Set the page title based on the page name
        $page_title = ucfirst($page); // Assuming you want to capitalize the page name
        $main_templateContent = str_replace('{title}', $page_title, $main_templateContent);
    } else {
        $dynamicContent = "Template not found.";
    }
} else {
    $dynamicContent = "Page not found.";
}

// Replace the {dynamic_content} placeholder with the dynamic content
$main_templateContent = str_replace('{dynamic_content}', $dynamicContent, $main_templateContent);

// Output the modified template
echo $main_templateContent;
?>

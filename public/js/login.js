function onSignIn(googleUser) {
    // Access user information from googleUser object
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId());
    console.log('Name: ' + profile.getName());
    console.log('Email: ' + profile.getEmail());
    // You can also get the user's ID token for server-side verification
    var idToken = googleUser.getAuthResponse().id_token;
    console.log('ID Token: ' + idToken);
 
    // Send the ID token to your server for server-side verification
    // Implement user registration or authentication logic on your server
 }
 
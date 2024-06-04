document.addEventListener("DOMContentLoaded", function () {
  // Get the current path
  var path = window.location.pathname;

  // Define a mapping of paths to nav link IDs
  var navLinks = {
    "/otv/": "otvNav",
    "/map": "mapNav",
    "/users/": "usersNav",
    "/profil/": "profileNav",
  };

  // Iterate over the mapping and set the active class
  for (var route in navLinks) {
    // Check if the path matches exactly or starts with the route for dynamic paths
    if (path === route || (route === "/profil/" && path.startsWith(route))) {
      document.getElementById(navLinks[route]).classList.add("active");
      break; // Exit the loop once we find a match
    }
  }
});

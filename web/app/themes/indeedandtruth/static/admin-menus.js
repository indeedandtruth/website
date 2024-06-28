// top menu can only have one child level
if ( document.getElementById("locations-top").checked ) {
    wpNavMenu.options.globalMaxDepth = 1;
}

// top menu can only have one child level
if ( document.getElementById("locations-bottom").checked ) {
    wpNavMenu.options.globalMaxDepth = 1;
}

function initAutocomplete() {
    var autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('autocomplete'),
        { types: ['geocode'] }
    );

    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();

        document.getElementsByName('address')[0].value = place.formatted_address;

        var addressComponents = {
            locality: '',
            country: '',
            administrative_area_level_2: '',
            postal_code: ''
        };

        place.address_components.forEach(component => {
            const addressType = component.types[0];
            if (addressComponents.hasOwnProperty(addressType)) {
                addressComponents[addressType] = component.long_name;
            }
        });

        var city = addressComponents.locality || addressComponents.administrative_area_level_2;
        var postal_code = addressComponents.postal_code || place.postal_town || place.route;

        document.getElementsByName('city')[0].value = city;
        document.getElementsByName('country')[0].value = addressComponents.country;
        document.getElementsByName('postal')[0].value = postal_code;
    });
}

google.maps.event.addDomListener(window, 'load', initAutocomplete);

// Class definition
var KTTypeahead = function() {

    var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
            'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
            'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
            'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
            'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
            'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
            'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
            'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
            'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
        ];

    // Private functions for addresses
    var savedAddresses = function() {
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };

        $('#sender_address1, #receiver_address1').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'addresses',
            source: substringMatcher(addresses)
        });
    }

    // Private functions for names
    var savedNames = function() {
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };

        $('#sender_name, #receiver_name, #customer_name').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'all_saved_names',
            source: substringMatcher(all_saved_names)
        });
    }

    // Private functions for phones
    var savedPhones = function() {
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };

        $('#sender_phone, #receiver_phone, #customer_phone').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'all_saved_phones',
            source: substringMatcher(all_saved_phones)
        });
    }

    // Private functions for emails
    var savedEmails = function() {
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };

        $('#sender_email, #receiver_email').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'all_saved_emails',
            source: substringMatcher(all_saved_emails)
        });
    }

    // Private functions for emails
    var shipmentNos = function() {
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };

        $('#make_payment_shipment_no').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'all_shipment_nos',
            source: substringMatcher(all_shipment_nos)
        });

    }

    return {
        // public functions
        init: function() {
            savedAddresses();
            savedNames();
            savedPhones();
            savedEmails();
            shipmentNos();
        }
    };
}();

jQuery(document).ready(function() {
    setTimeout(function() {
        KTTypeahead.init();
    }, 3000)
});
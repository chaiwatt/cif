import * as RequestApi from '../../../request-api.js';

var token = window.params.token
const url = window.location.href;
const segments = url.split('/');
var workScheduleId = segments[segments.length - 5];
var year = segments[segments.length - 3];
var month = segments[segments.length - 1];

checkIfExpired(year, month);

// $("#payday_date_range_wrapper").hide();
// $("#custom_date_range").on("click", function () {
//     $("#custom_date_range_wrapper").show();
//     $("#payday_date_range_wrapper").hide();
//     $("#payday_date_range").prop("checked", false);
// });

// $("#payday_date_range").on("click", function () {
//     $("#payday_date_range_wrapper").show();
//     $("#custom_date_range_wrapper").hide();
//     $("#custom_date_range").prop("checked", false);
// });

$(document).on('change', '#select_all', function (e) {
    $('.user-checkbox').prop('checked', this.checked);
});

$(document).on('change', '.user-checkbox', function (e) {
    if ($('.user-checkbox:checked').length == $('.user-checkbox').length) {
        $('#select_all').prop('checked', true);
    } else {
        $('#select_all').prop('checked', false);
    }
});


$(document).on('click', '#show_modal', function (e) {
    $('#modal-date-range').modal('show')
});

$(document).on('click', '#show_file_open', function (e) {
    $('#file-inputs').trigger('click');
});

$(document).on('click', '#import_for_all', function (e) {
    $('#file-input').trigger('click');
});

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchInput = $(this).val();
    var searchUrl = window.params.searchRoute
    RequestApi.postRequest(searchInput, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/groups/time-recording-system/schedulework/schedule/assignment/user/search?page=" + page
    RequestApi.postRequest(searchInput, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

function checkIfExpired(year, month) {
    // Get the current year and month using Moment.js
    var currentDate = moment();
    var currentYear = currentDate.year();
    var currentMonth = currentDate.month() + 1; // Note: Month is zero-indexed in Moment.js
    // Compare the year and month with the current year and month

    if ((parseInt(year) === parseInt(currentYear) && parseInt(month) < parseInt(currentMonth))) {
        $('#add_user_wrapper').hide();
        $('#expire_message').text('(หมดเวลา)');
    }
}

function isEndDateAfterStartDate(startDate, endDate) {
    var parsedStartDate = moment(startDate, 'DD/MM/YYYY', true); // Parse start date
    var parsedEndDate = moment(endDate, 'DD/MM/YYYY', true); // Parse end date

    if (!parsedStartDate.isValid() || !parsedEndDate.isValid()) {
        // Handle the case when either start date or end date is not a valid date
        return false;
    }

    if (parsedEndDate.isBefore(parsedStartDate)) {
        // Handle the case when endDate is before startDate
        return false;
    }

    return true;
}

$('#nextButton').on('click', function () {
    var isValid = validateForm(); // Replace 'validateForm()' with your actual validation function
    if (isValid) {
        stepper.next(); // Proceed to the next step if the form is valid
    }
});

function validateForm() {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    // Sample validation: Check if both start date and end date are filled
    if (startDate.trim() === '' || endDate.trim() === '') {
        return false;
    }
    return true;
}

$(document).on('change', '#file-inputs', function (event) {

    var loadedFiles = 0;
    var files = event.target.files;

    if (files.length < 1) {
        Swal.fire(
            'ผิดพลาด!',
            'โปรดเลือกอย่างน้อย 1 ไฟล์',
            'error'
        );
        $('#file-inputs').val(''); // Clear the file input value
        return;
    }

    // Reset arrays and flags
    var selectedEmployeeNos = [];
    var fileResultsArray = [];

    $('.user-checkbox:checked').each(function () {
        var employeeNo = $(this).closest('tr').find('td:nth-child(2)').text();
        selectedEmployeeNos.push(employeeNo);
    });


    // Process each file
    for (let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const contents = e.target.result;

            // Parse the CSV file
            const parsedData = Papa.parse(contents, { header: true });
            const fileResults = parsedData.data;

            // Store the results and selectedEmployeeNos for each file
            fileResultsArray.push(fileResults);

            loadedFiles++;
            // Combine data when all files are loaded
            if (loadedFiles === files.length) {

                const results = combineData(fileResultsArray, selectedEmployeeNos);

                if (results.length > 0) {
                    processFile(results, selectedEmployeeNos, year, month);
                }

                // Reset the file input value

                $('#file-inputs').val('');
            }
        };

        reader.readAsText(files[i]);
    }
});

function combineData(fileResultsArray, selectedEmployeeNos) {
    // Combine all data from the fileResultsArray into a single array
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    const allData = fileResultsArray.flat();

    // Create a map to store data for each specific AC-No
    const specificResultsMap = new Map();

    // Filter the data for each specific AC-No and store it in the map
    for (const specificACNo of selectedEmployeeNos) {
        const specificResults = allData.filter((row) => row['AC-No'] === specificACNo);
        specificResultsMap.set(specificACNo, specificResults);
    }

    // Create an array of all dates in the month (from the first day to the last day)
    const firstDate = moment.min(allData.filter(row => row['Date'] !== '' && row['Date']).map(row => moment(row['Date'], 'DD/MM/YYYY')));
    const lastDate = moment.max(allData.filter(row => row['Date'] !== '' && row['Date']).map(row => moment(row['Date'], 'DD/MM/YYYY')));

    const firstDayOfMonth = firstDate.clone().startOf('month');
    const lastDayOfMonth = lastDate.clone().endOf('month');
    const datesInMonth = [];
    const currentDate = firstDayOfMonth.clone();

    while (currentDate.isSameOrBefore(lastDayOfMonth, 'day')) {
        datesInMonth.push(currentDate.format('DD/MM/YYYY'));
        currentDate.add(1, 'day');
    }

    // Create a map to store missing dates for each specific AC-No
    const missingDatesMap = new Map();

    for (const specificACNo of selectedEmployeeNos) {
        missingDatesMap.set(specificACNo, []);
    }

    // Prepare missing dates before the loop
    for (const specificACNo of selectedEmployeeNos) {
        const specificResults = specificResultsMap.get(specificACNo);
        const specificDates = new Set(specificResults.map((row) => row['Date']));

        for (const date of datesInMonth) {
            if (!specificDates.has(date)) {
                const firstResult = specificResults.find((row) => moment(row['Date'], 'DD/MM/YYYY').isAfter(moment(date, 'DD/MM/YYYY')));
                const lastResult = specificResults.slice().reverse().find((row) => moment(row['Date'], 'DD/MM/YYYY').isBefore(moment(date, 'DD/MM/YYYY')));
                const name = firstResult ? firstResult['Name.'] : lastResult ? lastResult['Name.'] : '';
                const department = firstResult ? firstResult['Department'] : lastResult ? lastResult['Department'] : 'START';

                missingDatesMap.get(specificACNo).push({
                    'AC-No': specificACNo,
                    'Name.': name,
                    'Department': 'START',
                    'Date': date,
                    'Time': '',
                });
            }
        }
    }

    // Concatenate the missing dates with the filtered data for each specific AC-No
    const finalResults = [];

    for (const specificACNo of selectedEmployeeNos) {
        const specificResults = specificResultsMap.get(specificACNo);
        const missingDates = missingDatesMap.get(specificACNo);

        // Sort specificResults and missingDates by AC-No and Date
        specificResults.sort((a, b) => {
            const acNoComparison = a['AC-No'].localeCompare(b['AC-No']);
            if (acNoComparison === 0) {
                return moment(a['Date'], 'DD/MM/YYYY').diff(moment(b['Date'], 'DD/MM/YYYY'));
            }
            return acNoComparison;
        });

        missingDates.sort((a, b) => {
            const acNoComparison = a['AC-No'].localeCompare(b['AC-No']);
            if (acNoComparison === 0) {
                return moment(a['Date'], 'DD/MM/YYYY').diff(moment(b['Date'], 'DD/MM/YYYY'));
            }
            return acNoComparison;
        });

        // Prepend missingDates before the first date
        // const firstDateForACNo = moment(specificResults[0]['Date'], 'DD/MM/YYYY');
        try {
            var firstDateForACNo = moment(specificResults[0]['Date'], 'DD/MM/YYYY');
           
        } catch (error) {
            // console.log(specificACNo)
            // Handle the error here, for example, set a default date
            if (specificResults.length == 0) {
                Swal.fire(
                    'ผิดพลาด',
                    'ไม่พบพนักงานรหัส ' + specificACNo,
                    'warning'
                )
            } else {
                Swal.fire(
                    'ผิดพลาด',
                    'เลือกไฟล์ไม่ถูกต้อง',
                    'warning'
                )
            }
            return [];
        }
        let currentIndex = 0;

        for (const date of datesInMonth) {
            const momentDate = moment(date, 'DD/MM/YYYY');
            const specificResult = specificResults[currentIndex];

            if (momentDate.isBefore(firstDateForACNo, 'day')) {
                const foundMissing = missingDates.find((row) => moment(row['Date'], 'DD/MM/YYYY').isSame(momentDate, 'day'));
                finalResults.push(foundMissing);
            } else if (specificResult && momentDate.isSame(moment(specificResult['Date'], 'DD/MM/YYYY'), 'day')) {
                finalResults.push(specificResult);
                currentIndex++;
            } else {
                const foundMissing = missingDates.find((row) => moment(row['Date'], 'DD/MM/YYYY').isSame(momentDate, 'day'));
                finalResults.push(foundMissing);
            }
        }

        let isDateRangeValid = true; // Flag to indicate if the date range is valid

        // Return an empty array if the date range is not valid
        if (!isDateRangeValid) {
            return [];
        }
    }

    return finalResults.filter((result) => result !== undefined);
}

function processFile(results, selectedEmployeeNos, year, month) {
    // AC-No values to check
    // Check if the file's date is in the same year and month
    const fileDate = moment(results[0]['Date'], 'DD/MM/YYYY');

    // Filter the results based on AC-No values
    const filteredResults = results.filter(row => selectedEmployeeNos.includes(row['AC-No']));

    // Store missing AC-No values
    const missingEmployeeNos = selectedEmployeeNos.filter(employeeNo => !filteredResults.some(row => row['AC-No'] === employeeNo));

    // Process the filtered results and create a new array
    const processedResults = filteredResults.map(row => {
        // Remove the 'Name' keys
        // delete row['Department'];
        delete row['Name.'];

        const timeValue = row['Time'];

        if (timeValue === '') {
            row['Time'] = '00:00 00:00';
        } else {
            row['Time'] = timeValue;
        }

        // Convert date format from dd/mm/yyyy to yyyy-mm-dd
        const dateValue = row['Date'];
        const momentDate = moment(dateValue, 'DD/MM/YYYY');
        row['Date'] = momentDate.format('YYYY-MM-DD');

        return row;
    });

    // Check for missing AC-No values
    if (missingEmployeeNos.length === 0) {
        var batchImportUrl = window.params.batchImportRoute;
        var batchSize = 100; // Set the desired batch size

        // Split the processedResults into smaller batches
        var batches = [];
        for (var i = 0; i < processedResults.length; i += batchSize) {
            var batch = processedResults.slice(i, i + batchSize);
            batches.push(batch);
        }

        // Create an array to store the promises for each batch request
        var promises = [];
        $('#loading-indicator').css('display', 'flex');
        // Send requests for each batch
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        batches.forEach(function (batch) {
            var data = {
                'batch': batch,
                'month': month,
                'year': year,
                'start_date': startDate,
                'end_date': endDate,
                'workScheduleId': workScheduleId
            };
            var promise = RequestApi.postRequest(data, batchImportUrl, token);
            promises.push(promise);
        });

        // Wait for all batch requests to complete
        Promise.all(promises)
            .then(function (responses) {
                // console.log('All batches processed successfully');
                // Process the responses as needed
                $('#file-input').val('');
                Swal.fire(
                    'สำเร็จ!',
                    'นำเข้าสำเร็จ',
                    'success'
                );
            })
            .catch(function (error) {
                // console.error('Error processing batches');
            }).finally(function () {
                // Hide the loading indicator
                $('#loading-indicator').hide();
            });
    } else {
        alert(`ไม่พบรหัสพนักงาน: ${missingEmployeeNos.join(', ')}`);
    }

}


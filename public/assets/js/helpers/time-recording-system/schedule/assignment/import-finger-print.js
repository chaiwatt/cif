import * as RequestApi from '../../../request-api.js';

var token = window.params.token
const url = window.location.href;
const segments = url.split('/');
var workScheduleId = segments[segments.length - 5];
var year = segments[segments.length - 3];
var month = segments[segments.length - 1];
checkIfExpired(year, month);

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

$(document).on('change', '#file-input', function (event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    var selectedEmployeeNos = [];
    $('.user-checkbox:checked').each(function () {
        var employeeNo = $(this).closest('tr').find('td:nth-child(2)').text();
        selectedEmployeeNos.push(employeeNo);
    });

    if (selectedEmployeeNos.length === 0) {
        $('#file-input').val('');
        Swal.fire(
            'ผิดพลาด!',
            'โปรดเลือกพนักงาน',
            'error'
        )
        return; // Exit the function if selectedEmployeeNos is empty
    }

    reader.onload = function (e) {
        const contents = e.target.result;

        // Parse the CSV file
        const parsedData = Papa.parse(contents, { header: true });
        const results = parsedData.data;
        
        // Process the file
        processFile(results, selectedEmployeeNos, year, month);

        // Reset the file input value
        $('#file-input').val('');
    };

    reader.readAsText(file);
});

function processFile(results, selectedEmployeeNos, year, month) {
    // AC-No values to check
    // Check if the file's date is in the same year and month
    const fileDate = moment(results[0]['Date'], 'DD/MM/YYYY');

    if (fileDate.year() !== parseInt(year) || fileDate.month() + 1 !== parseInt(month)) {
        $('#file-input').val('');
        Swal.fire(
            'ผิดพลาด!',
            'เดือนและปีของไฟล์ไม่ตรงกับที่เลือก',
            'error'
        );
        return;
    }

    // Filter the results based on AC-No values
    const filteredResults = results.filter(row => selectedEmployeeNos.includes(row['AC-No']));

    // Store missing AC-No values
    const missingEmployeeNos = selectedEmployeeNos.filter(employeeNo => !filteredResults.some(row => row['AC-No'] === employeeNo));

    // Process the filtered results and create a new array
    const processedResults = filteredResults.map(row => {
        // Remove the 'Department' and 'Name' keys
        delete row['Department'];
        delete row['Name.'];

        const timeValue = row['Time'];

        if (timeValue === '') {
            row['Time'] = '00:00 00:00';
        } else {
            const times = timeValue.split(' ');

            if (times.length === 2) {
                const momentTime1 = moment(times[0], 'HH:mm');
                const momentTime2 = moment(times[1], 'HH:mm');

                const diffInMinutes = momentTime2.diff(momentTime1, 'minutes');

                if (diffInMinutes < 10) {
                    row['Time'] = momentTime2.format('HH:mm');
                }
            } else if (times.length > 2) {
                const validTimes = [];

                times.forEach(time => {
                    const momentTime = moment(time, 'HH:mm');
                    const isCloseToOtherTime = validTimes.some(validTime =>
                        momentTime.isBetween(moment(validTime).subtract(10, 'minutes'), moment(validTime).add(10, 'minutes'))
                    );

                    if (!isCloseToOtherTime) {
                        validTimes.push(momentTime);
                    }
                });

                // Convert validTimes array back to string format
                row['Time'] = validTimes.map(time => time.format('HH:mm')).join(' ');
            }
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
        batches.forEach(function (batch) {
            var data = {
                'batch': batch,
                'month': month,
                'year': year,
                'workScheduleId': workScheduleId
            };
            var promise = RequestApi.postRequest(data, batchImportUrl, token);
            promises.push(promise);
        });

        // Wait for all batch requests to complete
        Promise.all(promises)
            .then(function (responses) {
                console.log('All batches processed successfully');
                console.log(responses);
                // Process the responses as needed
                $('#file-input').val('');
                Swal.fire(
                    'สำเร็จ!',
                    'มอบหมายกะสำเร็จ',
                    'success'
                );
            })
            .catch(function (error) {
                console.error('Error processing batches');
                console.error(error);
            }).finally(function () {
                // Hide the loading indicator
                $('#loading-indicator').hide();
            });
    } else {
        alert(`ไม่พบรหัสพนักงาน: ${missingEmployeeNos.join(', ')}`);
    }


    // Check for missing AC-No values
    // if (missingEmployeeNos.length == 0) {
        
    //     var batchImportUrl = window.params.batchImportRoute
    //     RequestApi.postRequest(processedResults, batchImportUrl, token).then(response => {
    //         console.log('ok');
    //         console.log(response);
    //         // $('#table_container').html(response);
    //     }).catch(error => { })
    // }else{
    //     alert(`ไม่พบรหัสพนักงาน: ${missingEmployeeNos.join(', ')}`);
    // }

    // console.log('Processed results:', processedResults);
    // console.log('CSV file processing completed.');
}


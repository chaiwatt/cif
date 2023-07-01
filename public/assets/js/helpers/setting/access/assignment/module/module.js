import * as RequestApi from '../../../../request-api.js';

var token = window.params.token

$(document).on('click', '#un_assignment_module_button', function () {

    var groupId = $(this).data('id');
    var roleId = $(this).data('role');
    var moduleJsonUrl = window.params.moduleJsonRoute;

    // Additional code logic here...

    var dataSet = {
        'groupId': groupId,
        'roleId': roleId
    }
    RequestApi.postRequest(dataSet, moduleJsonUrl, token).then(response => {
        var group_data = JSON.parse(response);

        var group_data = JSON.parse(response);

        // Convert string "true" and "false" to boolean values
        function convertToBoolean(value) {
            return value === "true";
        }

        group_data = JSON.parse(JSON.stringify(group_data), function (key, value) {
            if (typeof value === "string") {
                if (value === "true" || value === "false") {
                    return convertToBoolean(value);
                }
            }
            return value;
        });

        // return
        var table = document.getElementById("module_modal_table");
        var tbody = table.getElementsByTagName("tbody")[0];
        tbody.innerHTML = '';


        group_data.forEach(function (module) {
            var moduleName = module.module_name;
            var moduleID = module.module_id;
            var enable = module.enable;

            module.jobs.forEach(function (job) {
                var jobRow = document.createElement("tr");

                if (job === module.jobs[0]) {
                    var moduleNameCell = document.createElement("td");
                    var enableCell = document.createElement("td");

                    moduleNameCell.textContent = moduleName;

                    // Create a div with icheck-primary and d-inline classes
                    var enableDiv = document.createElement("div");
                    enableDiv.className = "icheck-primary d-inline";

                    // Create an input element with icheck-bootstrap class
                    var enableInput = document.createElement("input");
                    enableInput.type = "checkbox";
                    enableInput.id = "checkbox_" + moduleName;
                    enableInput.checked = enable;

                    // Create a label element
                    var enableLabel = document.createElement("label");
                    enableLabel.setAttribute("for", "checkbox_" + moduleName);

                    enableDiv.appendChild(enableInput);
                    enableDiv.appendChild(enableLabel);
                    enableCell.appendChild(enableDiv);

                    moduleNameCell.rowSpan = module.jobs.length;
                    enableCell.rowSpan = module.jobs.length;

                    jobRow.appendChild(moduleNameCell);
                    jobRow.appendChild(enableCell);
                }

                var jobNameCell = document.createElement("td");
                var showCell = document.createElement("td");
                var createCell = document.createElement("td");
                var updateCell = document.createElement("td");
                var deleteCell = document.createElement("td");

                jobNameCell.textContent = job.job_name;
                jobNameCell.style.paddingLeft = "10px";

                // Create a div with icheck-primary and d-inline classes for show permission
                var showDiv = document.createElement("div");
                showDiv.className = "icheck-primary d-inline";

                // Create an input element with icheck-bootstrap class
                var showInput = document.createElement("input");
                showInput.type = "checkbox";
                showInput.id = "show_" + job.job_name;
                showInput.checked = enable ? job.permissions.show : false;

                // Create a label element
                var showLabel = document.createElement("label");
                showLabel.setAttribute("for", "show_" + job.job_name);

                showDiv.appendChild(showInput);
                showDiv.appendChild(showLabel);
                showCell.appendChild(showDiv);

                // Create a div with icheck-primary and d-inline classes for create permission
                var createDiv = document.createElement("div");
                createDiv.className = "icheck-primary d-inline";

                // Create an input element with icheck-bootstrap class
                var createInput = document.createElement("input");
                createInput.type = "checkbox";
                createInput.id = "create_" + job.job_name;
                createInput.checked = enable ? job.permissions.create : false;

                // Create a label element
                var createLabel = document.createElement("label");
                createLabel.setAttribute("for", "create_" + job.job_name);

                createDiv.appendChild(createInput);
                createDiv.appendChild(createLabel);
                createCell.appendChild(createDiv);

                // Create a div with icheck-primary and d-inline classes for update permission
                var updateDiv = document.createElement("div");
                updateDiv.className = "icheck-primary d-inline";

                // Create an input element with icheck-bootstrap class
                var updateInput = document.createElement("input");
                updateInput.type = "checkbox";
                updateInput.id = "update_" + job.job_name;
                updateInput.checked = enable ? job.permissions.update : false;

                // Create a label element
                var updateLabel = document.createElement("label");
                updateLabel.setAttribute("for", "update_" + job.job_name);

                updateDiv.appendChild(updateInput);
                updateDiv.appendChild(updateLabel);
                updateCell.appendChild(updateDiv);

                // Create a div with icheck-primary and d-inline classes for delete permission
                var deleteDiv = document.createElement("div");
                deleteDiv.className = "icheck-primary d-inline";

                // Create an input element with icheck-bootstrap class
                var deleteInput = document.createElement("input");
                deleteInput.type = "checkbox";
                deleteInput.id = "delete_" + job.job_name;
                deleteInput.checked = enable ? job.permissions.delete : false;

                // Create a label element
                var deleteLabel = document.createElement("label");
                deleteLabel.setAttribute("for", "delete_" + job.job_name);

                deleteDiv.appendChild(deleteInput);
                deleteDiv.appendChild(deleteLabel);
                deleteCell.appendChild(deleteDiv);

                jobRow.appendChild(jobNameCell);
                jobRow.appendChild(showCell);
                jobRow.appendChild(createCell);
                jobRow.appendChild(updateCell);
                jobRow.appendChild(deleteCell);

                tbody.appendChild(jobRow);
            });
        });

        showModuleModal();

        function getUpdatedValues() {
            var updatedGroup = [];

            group_data.forEach(function (module) {
                var moduleName = module.module_name;
                var moduleID = module.module_id;
                var enableCheckbox = document.getElementById("checkbox_" + moduleName);

                var updatedModule = {
                    'module_id': moduleID,
                    'module_name': moduleName,
                    'enable': enableCheckbox.checked,
                    'jobs': [],
                };

                module.jobs.forEach(function (job) {
                    var jobCheckbox = document.getElementById("show_" + job.job_name);
                    var createCheckbox = document.getElementById("create_" + job.job_name);
                    var updateCheckbox = document.getElementById("update_" + job.job_name);
                    var deleteCheckbox = document.getElementById("delete_" + job.job_name);

                    if (enableCheckbox.checked) {
                        var updatedJob = {
                            'job_id': job.job_id,
                            'job_name': job.job_name,
                            'permissions': {
                                'show': jobCheckbox.checked,
                                'create': createCheckbox.checked,
                                'update': updateCheckbox.checked,
                                'delete': deleteCheckbox.checked,
                            },
                        };
                    } else {
                        // If the parent module is disabled, uncheck all the job checkboxes
                        jobCheckbox.checked = false;
                        createCheckbox.checked = false;
                        updateCheckbox.checked = false;
                        deleteCheckbox.checked = false;

                        var updatedJob = {
                            'job_id': job.job_id,
                            'job_name': job.job_name,
                            'permissions': {
                                'show': false,
                                'create': false,
                                'update': false,
                                'delete': false,
                            },
                        };
                    }

                    updatedModule.jobs.push(updatedJob);
                });

                updatedGroup.push(updatedModule);
            });

            return updatedGroup;
        }

        $(document).on('click', '#bntSaveModule', function (event) {
            var updatedValues = getUpdatedValues();
            var updateModuleJsonUrl = window.params.updateModuleJsonRoute;
            var dataSet = {
                'groupId': groupId,
                'roleId': roleId,
                'updatedValues': updatedValues
            }
            RequestApi.postRequest(dataSet, updateModuleJsonUrl, token).then(response => {
                $('#modal-module').modal('hide');
                // Reload the window
                location.reload();
            });
        });

        // Get all values that may have changed (e.g., checkbox states) and return them in the same JSON format

        // Reload the window

    });


});

function showModuleModal() {
    $('#modal-module').modal('show');
}



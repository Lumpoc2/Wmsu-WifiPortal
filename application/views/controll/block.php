<?php
class PiHoleAPI {
    private $apiUrl;
    private $apiToken;

    public function __construct($piHoleUrl, $apiToken) {
        $this->apiUrl = rtrim($piHoleUrl, '/') . '/admin/api.php';
        $this->apiToken = $apiToken;
    }

    public function removeFromBlocklist($domain) {
        $url = $this->apiUrl . "?list=black&sub=" . urlencode($domain) . "&auth=" . $this->apiToken;
        return $this->sendRequest($url);
    }

    public function removeFromRegexBlocklist($regex) {
        $url = $this->apiUrl . "?list=regex_black&sub=" . urlencode($regex) . "&auth=" . $this->apiToken;
        return $this->sendRequest($url);
    }

    private function sendRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}

// Instantiate PiHoleAPI class
$piHole = new PiHoleAPI('10.10.10.6', 'e95d070407e39d43d738badabe42893dce0726e7a2930cef760eaa36b6027a52');

// Handle deletion when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'], $_POST['domain']) && $_POST['action'] === 'remove') {
        $domain = $_POST['domain'];
        $result = $piHole->removeFromBlocklist($domain);
        //echo "Domain '{$domain}' removed from blocklist. Result: " . print_r($result, true);
    } elseif (isset($_POST['action'], $_POST['regex']) && $_POST['action'] === 'remove_regex') {
        $regex = $_POST['regex'];
        $result = $piHole->removeFromRegexBlocklist($regex);
        //echo "Regex '{$regex}' removed from blocklist. Result: " . print_r($result, true);
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Block site(s) by GITHUB</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Domain and Regex List</h3>
                        </div>
                        <div class="card-body">
                            <div class="pb-3">
                                <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#modal-add-Url">
                                    Add Url
                                </button>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>ID</th>
                                            <th>Type</th>
                                            <th>Domain/Regex</th>
                                            <th>Enabled</th>
                                            <th>Date Added</th>
                                            <th>Date Modified</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $dbFilePath = '/etc/pihole/gravity.db'; // Path to SQLite database
                                    try {
                                        $pdo = new PDO('sqlite:' . $dbFilePath);
                                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $query = "SELECT * FROM domainlist LIMIT 100";
                                        $statement = $pdo->prepare($query);
                                        $statement->execute();
                                        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($rows as $row) {
                                            $datetime1 = date("Y-m-d H:i:s", $row['date_added']);
                                            $datetime2 = date("Y-m-d H:i:s", $row['date_modified']);
                                            $actionType = ($row['type'] == 3) ? 'remove_regex' : 'remove';
                                            $inputName = ($row['type'] == 3) ? 'regex' : 'domain';
                                            $displayType = ($row['type'] == 3) ? 'Regex' : 'Domain';

                                           echo "<tr>";
                                            echo "<td>
                                                    <form method='POST' style='display:inline;'>
                                                        <input type='hidden' name='action' value='{$actionType}'>
                                                        <input type='hidden' name='{$inputName}' value='{$row['domain']}'>
                                                        <button type='submit' class='btn btn-danger'><i class='fa fa-trash'></i> Remove</button>
                                                    </form>
                                                  </td>";
                                            echo "<td>{$row['id']}</td>";
                                            echo "<td>{$displayType}</td>";
                                            echo "<td>{$row['domain']}</td>";
                                            echo "<td>" . ($row['enabled'] == 1 ? "TRUE" : "FALSE") . "</td>";
                                            echo "<td>{$datetime1}</td>";
                                            echo "<td>{$datetime2}</td>";
                                            echo "<td>{$row['comment']}</td>";
                                            echo "</tr>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <div class="modal fade" id="modal-add-Url" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h4 class="modal-title">Add URL</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addUrlForm" action="<?= site_url('controll/BlockSite'); ?>" method="POST">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
                        </div>

                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="text" name="url" class="form-control" id="url" placeholder="Enter your URL"
                                required>
                            <small id="urlHelp" class="form-text text-muted">Example: https://example.com</small>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <script>
    $(document).ready(function() {
        // Form submission with validation
        $('#addUrlForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            // Perform frontend validation
            const url = $('#url').val();
            const name = $('#name').val();

            if (!isValidUrl(url)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Please enter a valid URL starting with http:// or https://.',
                    icon: 'error',
                    confirmButtonText: 'Okay'
                });
                return; // Stop further execution
            }

            if (isRestrictedUrl(url)) {
                Swal.fire({
                    title: 'Error',
                    text: 'This URL is not allowed.',
                    icon: 'error',
                    confirmButtonText: 'Okay'
                });
                return; // Stop further execution
            }

            // If validation passes, send an AJAX request
            const formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        }).then(() => {
                            // Reload or update the UI dynamically if needed
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    });
                }
            });
        });

        // Helper function to validate URL format
        function isValidUrl(string) {
            const pattern = new RegExp(
                '^(https?:\\/\\/)' + // Protocol (http or https)
                '((([a-zA-Z0-9-]+\\.)+[a-zA-Z]{2,})|' + // Domain name
                'localhost|' + // OR localhost
                '\\d{1,3}(\\.\\d{1,3}){3})' + // OR IPv4 address
                '(\\:\\d+)?(\\/[-a-zA-Z0-9%_.~+]*)*' + // Port and path
                '(\\?[;&a-zA-Z0-9%_.~+=-]*)?' + // Query string
                '(\\#[-a-zA-Z0-9_]*)?$', // Fragment locator
                'i'
            );
            return !!pattern.test(string);
        }

        // Function to check if URL is restricted (for example: block Instagram)
        function isRestrictedUrl(string) {
            const restrictedUrls = ['instagram.com']; // Add only domains you want to restrict
            const urlDomain = new URL(string).hostname;

            // Remove 'www.' from the domain before checking
            const domainWithoutWww = urlDomain.replace('www.', '');

            // Check if the URL matches any restricted domain
            return restrictedUrls.some(restricted => domainWithoutWww.includes(restricted));
        }
    });
    </script> -->

    <!-- <script>
    $(document).ready(function() {
        // Handle the form submission for remove action via AJAX
        $('.remove-form').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                type: "POST",
                url: $(this).attr('action'), // Make sure action is set in the form
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            // Reload the page or remove the row dynamically
                            location
                                .reload(); // Or you can remove the row from the table
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
    </script> -->
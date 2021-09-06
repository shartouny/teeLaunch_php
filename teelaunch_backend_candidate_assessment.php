<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .row {
            display: flex;

        }

        .chess-col {
            width: 30px;
            height: 30px;
            border: 1px solid black;

        }
    </style>
</head>

<body>
    <div class="container border border-info my-3 p-3">
        <div class="row">
            <div class="col-1"> <strong> Name: </strong></div>
            <div class="col-md-6">Jad Shartouny</div>
        </div>
        <div class="row">
            <div class="col-1"> <strong> Type: </strong></div>
            <div class="col-md-6">PHP Test</div>
        </div>
    </div>
    <div class="container">

        <div class="row mt-4">
            <div class="col-md-4">
                <button class="btn btn-primary" data-show=".checkHtml">Check Html</button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-secondary" data-show=".check-brackets">Check Brackets</button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-info" data-show=".drowChess">Drow Chess</button>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

            <div class="checkHtml d-none">
                <div class="row my-3">
                    <div class="col-4 lable-col">
                        Enter HTML To Check
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input class="form-control" type="text" name="tags">
                    </div>
                    <div class="col-md-4">
                        <input type="submit" name="action" value="checkHtml">
                    </div>
                </div>
            </div>
            <div class="check-brackets d-none">
                <div class="row my-3">
                    <div class="col-4 lable-col">
                        Enter brackets To Check
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="brackets">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" name="action" value="checkBrackets">
                    </div>
                </div>
            </div>

            <div class="drowChess d-none">
                <div class="row my-3">
                    <div class="col-4 lable-col">
                        Enter number of rows and columns To Check
                    </div>
                </div>
                <div class="row">
                    <div class="form-lable"></div>
                    <div class="col-md-4">
                        <input class="form-control" type="number" name="rows">
                    </div>

                    <div class="col-md-4">
                        <input class="form-control" type="number" name="cols">
                    </div>

                    <div class="col-md-4">
                        <input type="submit" name="action" value="drowChess">
                    </div>
                </div>
            </div>
        </form>

        <?php
        if (isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'drowChess') {
                $cols = 4;
                $rows = 4;
                if (isset($_REQUEST['cols']) && !empty($_REQUEST['cols']) && isset($_REQUEST['rows']) && !empty($_REQUEST['rows'])) {
                    $cols = $_REQUEST['cols'];
                    $rows = $_REQUEST['rows'];
                }
                drowChess($rows, $cols);
            } elseif ($_REQUEST['action'] == 'checkBrackets') {
                if (isset($_REQUEST['brackets']) && !empty($_REQUEST['brackets'])) {
                    $request = $_REQUEST['brackets'];
                    echo '<div class="row mt-5 result">
                            <div class="col-auto my-auto">
                                <h2 class="alert-success"> ' . checkBrackets($request) . '</h2>
                            </div>
                        </div>';
                } else {
                    echo '<div class="row mt-5 result">
                        <div class="col-auto my-auto">
                            <h2 class="alert-danger">Please fill the required fields</h2>
                        </div>
                    </div>';
                }
            } elseif ($_REQUEST['action'] == 'checkHtml') {
                if (isset($_REQUEST['tags']) && !empty($_REQUEST['tags'])) {
                    $str = $_REQUEST['tags'];
                    if (is_array(checkHtmlElements($str))) {
                        foreach (checkHtmlElements($str) as $val) {
                            echo
                                '<div class="row mt-5 result">
                                    <div class="col-auto my-auto">
                                        <h2 class="alert-danger"> ' . $val . '</h2>
                                    </div>
                                </div>';
                        }
                    } else {
                        echo
                        '<div class="row mt-5 result">
                            <div class="col-auto my-auto">
                                <h2 class="alert-success"> ' . checkHtmlElements($str) . '</h2>
                            </div>
                        </div>';
                    }
                } else {
                    echo
                        '<div class="row mt-5 result">
                            <div class="col-auto my-auto">
                                <h2 class="alert-danger">Please fill the required fields</h2>
                            </div>
                        </div>';
                }
            }
        }

        function drowChess($rows = 4, $cols = 4)
        {
            echo '<div class="container result mt-5">';
            for ($i = 0; $i < $rows; $i++) {
                echo '<div class="row">';
                for ($j = 0; $j < $cols; $j++) {
                    if (($j + $i) % 2 != 0) {
                        $bg = 'black';
                    } else {
                        $bg = 'white';
                    }
                    echo '<div class="chess-col" style="background-color:' . $bg . '"></div>';
                }
                echo '</div>';
            }
            echo '</div>';
        }


        function checkBrackets($brackets)
        {
            // {([])}
            $brackets = str_split($brackets);
            if (count($brackets) % 2 != 0) {
                echo 'invalid';
            }
            $validBrackets = [
                '{' => '}',
                '[' => ']',
                '(' => ')',
            ];
            for ($i = 0; $i < count($brackets); $i++) {
                if (array_key_exists($brackets[$i], $validBrackets)) {
                    $openingBrackets[] = $brackets[$i];
                } else {
                    $closingBrackets[] = $brackets[$i];
                    if ($brackets[$i] != $validBrackets[end($openingBrackets)]) {
                        return 'invalid';
                    } else {
                        array_pop($openingBrackets);
                    }
                    // echo 'valid';
                }
            }
            return 'valid';
        }

        function checkHtmlElements($str)
        {
            if(!preg_match('/<.*?>/', $str)){
                return ' Please Insert at least one html element';
            }
            preg_match_all(
                "|<.*?>|",
                "$str",
                $out,
            );
          
            $tags = array();
            foreach ($out as $v) {
                foreach ($v as $k) {
                    $tags[] =  str_replace(['<', '>'], '', $k);
                }
            }

            $openingTags = array();
            $unclosedTags = array();
            if (count($tags) % 2 != 0) {
                return 'make sure to close all tags';
            }
            for ($i = 0; $i < count($tags); $i++) {
                if (!preg_match('/\//', $tags[$i])) {
                    $openingTags[] = explode(' ', $tags[$i])[0];
                } elseif (preg_match('/\//', $tags[$i])) {
                    if (str_replace('/', '', $tags[$i]) != $openingTags[count($openingTags) - 1]) {
                        $unclosedTags[] = $tags[$i];
                        $errorTags[] = $openingTags[count($openingTags) - 1];
                        array_pop($openingTags);
                    } else {
                        array_pop($openingTags);
                    }
                }
            }
            if (!empty($errorTags)) {
                return $errorTags;
            } else {
                return 'The Elements are nested correctly.';
            }
        }
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('button').each(function() {
                $(this).on('click', function() {
                    $('.result').remove();
                    $($(this).data('show')).removeClass('d-none').siblings().addClass('d-none');
                })
            })
        });
    </script>
</body>

</html>
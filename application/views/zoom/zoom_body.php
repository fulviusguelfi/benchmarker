<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<nav id="nav-tool" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">MyMeetingApp</a>
        </div>
        <div id="navbar">
            <form class="navbar-form navbar-right" id="meeting_form">
                <div class="form-group">
                    <input type="text" name="display_name" id="display_name" value="JSSDK1.3.8#Local" placeholder="Name" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="text" name="meeting_number" id="meeting_number" value="" placeholder="Meeting Number" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" id="join_meeting">Join</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>

<script src="node_modules/react/dist/react.min.js"></script>
<script src="node_modules/react-dom/dist/react-dom.min.js"></script>
<script src="node_modules/redux/dist/redux.min.js"></script>
<script src="node_modules/redux-thunk/dist/redux-thunk.min.js"></script>
<script src="node_modules/lodash/lodash.min.js"></script>
<script src="node_modules/jquery/dist/jquery.min.js"></script>

<script src="./static/app.min.js"></script>

<script>

</script>

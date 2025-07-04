<?php
session_start();
session_destroy(); // Clear session
echo "Logged out successfully";

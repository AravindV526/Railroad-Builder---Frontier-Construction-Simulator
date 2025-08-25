<?php
include 'auth.php';
include 'tasks.php';
include 'resources.php';

// Get data from database
$tasks = getTasks();
$resources = getResources();
$progressData = getProgress();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Railroad Builder - Frontier Construction Simulator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Your existing CSS styles here */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        :root {
            --primary: #2c3e50;
            --secondary: #e74c3c;
            --accent: #3498db;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #2ecc71;
            --warning: #f39c12;
            --danger: #e74c3c;
            --gray: #95a5a6;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            background-attachment: fixed;
            color: #333;
            min-height: 100vh;
            padding-bottom: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: var(--primary);
            color: white;
            padding: 15px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            font-size: 28px;
            color: var(--secondary);
        }
        
        .logo h1 {
            font-size: 24px;
            font-weight: 700;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        
        nav a:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .auth-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background-color: var(--accent);
            color: white;
        }
        
        .btn-secondary {
            background-color: var(--secondary);
            color: white;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid white;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .hero {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .hero h2 {
            font-size: 36px;
            margin-bottom: 15px;
            color: var(--dark);
        }
        
        .hero p {
            font-size: 18px;
            color: #555;
            max-width: 800px;
            margin: 0 auto 20px;
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 20px;
            margin: 30px 0;
        }
        
        .sidebar {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar h3 {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light);
        }
        
        .resource-list {
            list-style: none;
        }
        
        .resource-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }
        
        .main-content {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .section-title {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .task-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .task-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            transition: transform 0.3s;
        }
        
        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .task-card h4 {
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .progress-bar {
            height: 10px;
            background-color: #eee;
            border-radius: 5px;
            margin: 10px 0;
            overflow: hidden;
        }
        
        .progress {
            height: 100%;
            background-color: var(--success);
            border-radius: 5px;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 30px 0;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card i {
            font-size: 36px;
            color: var(--accent);
            margin-bottom: 10px;
        }
        
        .stat-card h3 {
            font-size: 32px;
            margin-bottom: 5px;
            color: var(--dark);
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            border-radius: 10px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .close {
            font-size: 24px;
            cursor: pointer;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            color: white;
        }
        
        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            nav ul {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-train"></i>
                    <h1>Railroad Builder</h1>
                </div>
                
                <nav>
                    <ul>
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Tasks</a></li>
                        <li><a href="#">Resources</a></li>
                        <li><a href="#">Progress</a></li>
                    </ul>
                </nav>
                
                <div class="auth-buttons">
                    <?php if (isLoggedIn()): ?>
                        <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                        <a href="?logout=true" class="btn btn-outline">Logout</a>
                    <?php else: ?>
                        <button class="btn btn-outline" onclick="openModal('loginModal')">Login</button>
                        <button class="btn btn-primary" onclick="openModal('registerModal')">Register</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    
    <div class="container">
        <div class="hero">
            <h2>Build Your Frontier Railroad</h2>
            <p>Plan tasks, manage resources, and track progress as you construct your railroad across the untamed frontier. Strategic planning and resource management are key to your success!</p>
            <button class="btn btn-secondary">Start Building</button>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <i class="fas fa-tasks"></i>
                <h3><?php echo count($tasks); ?></h3>
                <p>Active Tasks</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-hard-hat"></i>
                <h3><?php echo $resources[0]['max']; ?></h3>
                <p>Workers Available</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-route"></i>
                <h3><?php echo $progressData['overall']; ?><span>%</span></h3>
                <p>Overall Progress</p>
            </div>
        </div>
        
        <div class="dashboard">
            <div class="sidebar">
                <h3>Resource Allocation</h3>
                <ul class="resource-list">
                    <?php foreach ($resources as $resource): ?>
                    <li>
                        <span><?php echo $resource['name']; ?></span>
                        <span><?php echo $resource['current']; ?>/<?php echo $resource['max']; ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                
                <h3>Recent Notifications</h3>
                <ul class="resource-list">
                    <li>
                        <i class="fas fa-info-circle" style="color: var(--accent);"></i>
                        <span>New resources arrived</span>
                    </li>
                    <li>
                        <i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i>
                        <span>Task #12 behind schedule</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle" style="color: var(--success);"></i>
                        <span>Section 3 completed</span>
                    </li>
                </ul>
            </div>
            
            <div class="main-content">
                <div class="section-title">
                    <h3>Current Tasks</h3>
                    <button class="btn btn-primary" onclick="openModal('addTaskModal')">Add New Task</button>
                </div>
                
                <div class="task-grid">
                    <?php foreach ($tasks as $task): ?>
                    <div class="task-card">
                        <h4><?php echo htmlspecialchars($task['title']); ?></h4>
                        <p><?php echo htmlspecialchars($task['description']); ?></p>
                        <div class="progress-bar">
                            <div class="progress" style="width: <?php echo $task['progress']; ?>%"></div>
                        </div>
                        <p>Progress: <?php echo $task['progress']; ?>%</p>
                        <p><strong>Resources:</strong> <?php echo $task['workers']; ?> workers, <?php echo $task['tools']; ?> tools</p>
                        <div style="margin-top: 10px;">
                            <button class="btn btn-primary" onclick="openEditTaskModal(<?php echo $task['id']; ?>)">Edit</button>
                            <a href="?delete_task=<?php echo $task['id']; ?>" class="btn btn-secondary">Delete</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="section-title" style="margin-top: 30px;">
                    <h3>Project Progress</h3>
                </div>
                
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Overall Completion</span>
                        <span><?php echo $progressData['overall']; ?>%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $progressData['overall']; ?>%; background-color: var(--accent);"></div>
                    </div>
                    
                    <div style="display: flex; margin-top: 20px;">
                        <div style="flex: 1; padding: 10px; border-right: 1px solid #eee;">
                            <h4>Terrain Cleared</h4>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $progressData['terrain_cleared']; ?>%;"></div>
                            </div>
                            <p><?php echo $progressData['terrain_cleared']; ?>% complete</p>
                        </div>
                        <div style="flex: 1; padding: 10px; border-right: 1px solid #eee;">
                            <h4>Track Laid</h4>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $progressData['track_laid']; ?>%;"></div>
                            </div>
                            <p><?php echo $progressData['track_laid']; ?>% complete</p>
                        </div>
                        <div style="flex: 1; padding: 10px;">
                            <h4>Stations Built</h4>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $progressData['stations_built']; ?>%;"></div>
                            </div>
                            <p><?php echo $progressData['stations_built']; ?>% complete</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Login to Your Account</h2>
                <span class="close" onclick="closeModal('loginModal')">&times;</span>
            </div>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>
        </div>
    </div>
    
    <!-- Register Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New Account</h2>
                <span class="close" onclick="closeModal('registerModal')">&times;</span>
            </div>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <button type="submit" name="register" class="btn btn-secondary" style="width: 100%;">Register</button>
            </form>
        </div>
    </div>
    
    <!-- Add Task Modal -->
    <div id="addTaskModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Task</h2>
                <span class="close" onclick="closeModal('addTaskModal')">&times;</span>
            </div>
            <form method="POST">
                <div class="form-group">
                    <label for="title">Task Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter task title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Enter task description" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                </div>
                <div class="form-group">
                    <label for="workers">Workers Needed</label>
                    <input type="number" id="workers" name="workers" min="0" value="0" required>
                </div>
                <div class="form-group">
                    <label for="tools">Tools Needed</label>
                    <input type="number" id="tools" name="tools" min="0" value="0" required>
                </div>
                <button type="submit" name="add_task" class="btn btn-primary" style="width: 100%;">Add Task</button>
            </form>
        </div>
    </div>
    
    <!-- Edit Task Modal -->
    <div id="editTaskModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Task</h2>
                <span class="close" onclick="closeModal('editTaskModal')">&times;</span>
            </div>
            <form method="POST">
                <input type="hidden" id="edit_id" name="id">
                <div class="form-group">
                    <label for="edit_title">Task Title</label>
                    <input type="text" id="edit_title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_progress">Progress (%)</label>
                    <input type="number" id="edit_progress" name="progress" min="0" max="100" required>
                </div>
                <div class="form-group">
                    <label for="edit_workers">Workers</label>
                    <input type="number" id="edit_workers" name="workers" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit_tools">Tools</label>
                    <input type="number" id="edit_tools" name="tools" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit_status">Status</label>
                    <select id="edit_status" name="status" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <button type="submit" name="update_task" class="btn btn-primary" style="width: 100%;">Update Task</button>
            </form>
        </div>
    </div>
    
    <footer>
        <div class="container">
            <p>Railroad Builder Simulation Platform &copy; 2023. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Modal functionality
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
        
        // Open edit task modal with data
        function openEditTaskModal(taskId) {
            // In a real application, you would fetch task data via AJAX
            // For this example, we'll simulate it
            fetch('get_task.php?id=' + taskId)
                .then(response => response.json())
                .then(task => {
                    document.getElementById('edit_id').value = task.id;
                    document.getElementById('edit_title').value = task.title;
                    document.getElementById('edit_description').value = task.description;
                    document.getElementById('edit_progress').value = task.progress;
                    document.getElementById('edit_workers').value = task.workers;
                    document.getElementById('edit_tools').value = task.tools;
                    document.getElementById('edit_status').value = task.status;
                    openModal('editTaskModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading task data');
                });
        }
        
        // Simulate progress updates
        setInterval(() => {
            const progressBars = document.querySelectorAll('.progress');
            progressBars.forEach(bar => {
                if (Math.random() > 0.7) {
                    const currentWidth = parseInt(bar.style.width);
                    if (currentWidth < 100) {
                        bar.style.width = (currentWidth + 1) + '%';
                        bar.parentElement.nextElementSibling.textContent = 
                            'Progress: ' + (currentWidth + 1) + '%';
                    }
                }
            });
        }, 3000);
    </script>
</body>
</html>
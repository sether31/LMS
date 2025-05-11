# Kitchenomachia Academy!

* Kitchenomachia Academy is an online culinary classroom and can unlock your cooking potential with interactive courses, self-paced lessons, and fun quizzes. Complete a course and earn a certificate, and show the world you're a good chef!👨‍🍳🏆

## User Features
1. **Enroll in a course**
2. **View, complete and unlock next modules after the current modules**
3. **View, complete and unlock next lesson after the current lesson**
4. **Take quizzes**
5. **Get certificate of completion**

## Admin Features
1. **Create course**
2. **Create modules under course**
3. **Create lessons under modules**
4. **Publish and unpublish courses**
5. **Recover deleted courses**
6. **Create quiz every module before allowing user to go to next module (prerequisite: finish all lesson -> take quiz -> pass -> unlock next module -> download certificate)**
7. **Generate certificate**

## Installation

#### 1. **Clone the repository:**
```cmd
git clone git@github.com:sether31/Kitchenomachia-Academy.git
```

#### 2. **Install dependencies:**
```cmd

npm install
```

#### 3. **Import the database:**
- Launch your XAMPP and start your Apache and MySql.
- Open admin and create database name "kitchenomachia_academydb".
- Select the database, click import and select the kitchenomachia_academydb.sql file and save it.

#### 4. **Set up a local server with XAMPP:**
- After Launching your XAMPP.
- Place the Kitchenomachia-Academy project folder inside the htdocs directory of your XAMPP installation (this is found in C:\xampp\htdocs).
- Finally, Open your browser and go to http://localhost/Kitchenomachia-Academy/index.php to access the platform locally.

## Technologies Used
#### Frontend
  + HTML & CSS
  + ESLint
  + JavaScript (ES6+)
  + Chart.js (JS Library)
  + Node package manager (NPM)

#### Backend:
  + PHP
  + MySQL
  + Mailer (PHP Library)
  + FPDF (PHP Library)

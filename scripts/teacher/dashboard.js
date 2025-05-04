import {  } from '../../node_modules/chart.js/dist/chart.umd.js';


const totalModuleLesson = new Chart(document.getElementById('total-module-lesson'), {
  type: 'bar',
  data: {
    labels: coursesData.map(course => course.course_name),  
    datasets: [
      {
        label: 'Modules',
        data: coursesData.map(course => course.modules),  
        backgroundColor: 'rgba(247, 242, 238, 1)'
      },
      {
        label: 'Lessons',
        data: coursesData.map(course => course.lessons), 
        backgroundColor: 'rgba(106, 14, 39, 1)'
      }
    ]
  },
  options: {
    plugins: {
      title: { display: true, text: 'Number of Modules and Lessons per course' },
      legend: { position: 'bottom' }
    },
    responsive: true,
    maintainAspectRatio: false 
  }
});




const totalAttempts = new Chart(document.getElementById('total-attempts'), {
  type: 'bar',
  data: {
    labels: attemptData.map(data => data.title),
    datasets: [{
      label: 'Attempts',
      data: attemptData.map(data => parseInt(data.total_attempts)),
      backgroundColor: 'rgba(106, 14, 39, 1)'
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: 'Total Quiz Attempts Per Course'
      },
      legend: {
        position: 'bottom'
      }
    },
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
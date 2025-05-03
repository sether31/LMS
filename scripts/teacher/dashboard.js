import {  } from '../../node_modules/chart.js/dist/chart.umd.js';


const totalModuleLesson = new Chart(document.getElementById('total-module-lesson'), {
  type: 'bar',
  data: {
    labels: coursesData.map(course => course.course_name),  // Course names from PHP
    datasets: [
      {
        label: 'Modules',
        data: coursesData.map(course => course.modules),  // Total modules for each course
        backgroundColor: 'rgba(247, 242, 238, 1)'
      },
      {
        label: 'Lessons',
        data: coursesData.map(course => course.lessons),  // Total lessons for each course
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
    labels: ['Course 1', 'Course 2', 'Course 3', 'Course 4'],
    datasets: [
      {
        label: 'Attempts rate (%)',
        data: [85, 70, 60, 90],
        backgroundColor: 'rgba(106, 14, 39, 1)'
      }
    ]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: 'Total Attempts Per Course'
      },
      legend: {
        position: 'bottom'
      }
    },
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true,
        max: 100
      }
    }
  }
});


const totalPassFail = new Chart(document.getElementById('total-pass-fail'), {
  type: 'pie',
  data: {
    labels: ['Passed', 'Failed'],
    datasets: [{
      label: 'Student Status',
      data: [26, 100], 
      backgroundColor: [
        'rgba(247, 242, 238, 1)',  
        'rgba(106, 14, 39, 1)' 
      ],
      borderColor: [
        'rgba(247, 242, 238, 1)',
        'rgba(106, 14, 39, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: 'Total of Students Pass/Fail Failed'
      },
      legend: {
        position: 'bottom'
      }
    },
    animation: {
      animateScale: true,
      animateRotate: true
    },
    responsive: true,
    maintainAspectRatio: false
  }
});


// dl
function downloadChart(chartId) {
  const canvas = document.getElementById(chartId);
  const link = document.createElement('a');
  link.download = chartId + '.png';
  link.href = canvas.toDataURL('image/png');
  link.click();
}

function downloadCSV(chartId) {
  const chart = Chart.getChart(chartId);
  let csvContent = 'Label,Value\n';
  chart.data.labels.forEach((label, index) => {
    chart.data.datasets.forEach(dataset => {
      csvContent += `${label},${dataset.data[index]}\n`;
    });
  });
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = chartId + '.csv';
  link.click();
}
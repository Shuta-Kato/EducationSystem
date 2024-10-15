let currentMonth = new Date(); 
    
function goToPrevMonth() {
    currentMonth.setMonth(currentMonth.getMonth() - 1); 
    updateDisplay(); 
}

function goToNextMonth() {
    currentMonth.setMonth(currentMonth.getMonth() + 1); 
    updateDisplay(); 
}

function updateDisplay() {
    let monthDisplay = document.getElementById('monthDisplay');
    let year = currentMonth.getFullYear();
    let month = String(currentMonth.getMonth() + 1).padStart(2, '0');
    let monthKey = `${year}-${month}`;

    monthDisplay.innerText = `${year}年${month}月のスケジュール`;

    let currentGrade = document.getElementById('currentGradeDisplay').innerText;
    fetchSchedule(monthKey, currentGrade);
}

function fetchSchedule(month, grade) {
    console.log(`Requesting schedule for: ${month} for grade: ${grade}`); 
    fetch(`/EducationSystem/public/user/schedules/${month}/${grade}`) 
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        displaySchedule(data);
    });
        
}

function selectGrade(grade) {
    let currentGradeDisplay = document.getElementById('currentGradeDisplay');
    currentGradeDisplay.innerText = grade;

    let buttons = document.querySelectorAll('.grade button');
    buttons.forEach(button => {
        button.classList.remove('selected');
    });

    const selectedButton = [...buttons].find(button => button.innerText === grade);
    if (selectedButton) {
        selectedButton.classList.add('selected');
    }

    let month = currentMonth.getFullYear() + '-' + String(currentMonth.getMonth() + 1).padStart(2, '0'); // 現在の月を取得
    fetchSchedule(month, grade);  
}

function displaySchedule(schedules) {
    let scheduleContent = document.getElementById('scheduleContent');
    scheduleContent.innerHTML = '';

    if (schedules.length === 0) {
        scheduleContent.innerHTML = '<p>スケジュールがありません。</p>';
        return; 
    }

    let groupedSchedules = schedules.reduce((acc, item) => {
        if (!acc[item.date]) {
            acc[item.date] = [];
        }
        acc[item.date].push(item);
        return acc;
    }, {});

    for (let date in groupedSchedules) {
        let schedule = document.createElement('div');
        schedule.className = 'video';
        schedule.innerHTML = `<img src="${groupedSchedules[date][0].thumbnail}" alt="動画サムネイル">`; 
        
        let title = document.createElement('a');
        title.className = 'curriculum_title';
        title.innerText = groupedSchedules[date][0].title;
        title.href = '#'; 
        title.onclick = (e) => {
            e.preventDefault();
        };

        schedule.appendChild(title);
        
        let list = document.createElement('ul');

        groupedSchedules[date].forEach(item => {
            let listItem = document.createElement('li');
            listItem.innerHTML = `${item.date} ${item.time}`; 
            list.appendChild(listItem);
        });

        schedule.appendChild(list); 
        scheduleContent.appendChild(schedule); 
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('currentGradeDisplay').innerText = '小学校1年生';
    updateDisplay();
});
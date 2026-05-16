const API_KEY = "YOUR_API_KEY_HERE";

document.addEventListener('DOMContentLoaded', () => {
    const gameForm = document.getElementById('gameForm');
    if (gameForm) {
        gameForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            document.getElementById('loading').style.display = 'block';
            
            const games = [
                { title: document.getElementById('game1').value, score: document.getElementById('score1').value },
                { title: document.getElementById('game2').value, score: document.getElementById('score2').value },
                { title: document.getElementById('game3').value, score: document.getElementById('score3').value }
            ];

            try {
                const results = await Promise.all(games.map(g => fetchGame(g)));
                const analysis = calculateDivergence(results);
                localStorage.setItem('game_data', JSON.stringify(analysis));
                window.location.href = 'results.html';
            } catch (err) {
                alert("Error fetching data. Check your API key or game titles.");
                document.getElementById('loading').style.display = 'none';
            }
        });
    }

    if (window.location.pathname.includes('results.html')) {
        const data = JSON.parse(localStorage.getItem('game_data'));
        if (data) {
            document.getElementById('avgDivergence').textContent = data.avg;
            const grid = document.getElementById('resultsGrid');
            data.games.forEach(game => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <img src="${game.image}">
                    <h3>${game.name}</h3>
                    <p>You: ${game.user_score} | Critics: ${game.critic_score}</p>
                `;
                grid.appendChild(card);
            });
        }
    }
});

async function fetchGame(game) {
    const url = `https://api.rawg.io/api/games?key=${API_KEY}&search=${encodeURIComponent(game.title)}`;
    const res = await fetch(url);
    const data = await res.json();
    if (data.count > 0) {
        const g = data.results[0];
        return {
            name: g.name,
            user_score: game.score,
            critic_score: g.metacritic || "N/A",
            image: g.background_image
        };
    }
    throw new Error("Not found");
}

function calculateDivergence(games) {
    let total = 0, count = 0;
    games.forEach(g => {
        if (g.critic_score !== "N/A") {
            total += Math.abs(g.user_score - g.critic_score);
            count++;
        }
    });
    return { games, avg: count > 0 ? (total / count).toFixed(2) : 0 };
}

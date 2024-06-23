from flask import Flask, request, jsonify
import pandas as pd
from recommendation import suggest_coffee

app = Flask(__name__)

# Recommendation page route
@app.route('/recommendation', methods=['POST'])
def recommendation():
    if request.method == 'POST':
        data = request.get_json()
        q1 = data.get('q1', [])
        q2 = data.get('q2', [])
        q3 = data.get('q3', [])
        q4 = data.get('q4', [])
        q5 = data.get('q5', [])
        q6 = data.get('q6', [])

        # Find recommendation based on user input
        user_input = (q1, q2, q3, q4, q5, q6)
        suggestion = suggest_coffee(user_input)
        
        return jsonify({'suggestion': suggestion})

if __name__ == '__main__':
    app.run(debug=True)

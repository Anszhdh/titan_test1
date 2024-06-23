import itertools
import pandas as pd

# Define the options for each question
q1_options = ["Black", "Cream", "Sugar", "None of the above"]
q2_options = ["Nutty Flavor", "Fruity Flavor", "Chocolatey Flavor", "Spicy Flavor"]
q3_options = ["Light Roast", "Medium Roast", "Dark Roast", "Espresso Roast"]
q4_options = ["Drip Coffee Maker", "French Press", "Espresso Machine", "Pour Over"]
q5_options = ["Decaf", "Low caffeine", "Regular caffeine", "High caffeine"]
q6_options = ["Whole beans", "Coarse grind (for French press)", "Medium grind (for drip coffee makers)", "Fine grind (for espresso)"]

# Create a DataFrame with all possible combinations
combinations = list(itertools.product(q1_options, q2_options, q3_options, q4_options, q5_options, q6_options))
df = pd.DataFrame(combinations, columns=['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6'])

# For demonstration, assign random coffee recommendations for each combination
import random
coffee_recommendations = [
    "Ethiopian Yirgacheffe", "Colombian Supremo", "Guatemalan Antigua", "Costa Rican Tarrazu",
    "Brazilian Santos", "Jamaican Blue Mountain", "Sumatran Mandheling", "Kenyan AA",
    "Hawaiian Kona", "Panama Geisha", "Tanzanian Peaberry", "Ecuadorian Vilcabamba"
]

df['Recommendation'] = [random.choice(coffee_recommendations) for _ in range(len(df))]

def suggest_coffee(user_input):
    """
    Suggest a coffee based on user input.

    Args:
    user_input (tuple): A tuple containing user inputs for each question.

    Returns:
    str: A coffee recommendation.
    """
    # Filter the DataFrame based on user input
    filtered_df = df[
        (df['Q1'] == user_input[0]) &
        (df['Q2'] == user_input[1]) &
        (df['Q3'] == user_input[2]) &
        (df['Q4'] == user_input[3]) &
        (df['Q5'] == user_input[4]) &
        (df['Q6'] == user_input[5])
    ]

    if not filtered_df.empty:
        # Return the first recommendation found
        return filtered_df['Recommendation'].iloc[0]
    else:
        return "No recommendation found based on your preferences."

if __name__ == "__main__":
    # Example usage
    user_input_example = ("Black", "Nutty Flavor", "Medium Roast", "French Press", "Regular caffeine", "Whole beans")
    recommendation = suggest_coffee(user_input_example)
    print("Coffee recommendation:", recommendation)

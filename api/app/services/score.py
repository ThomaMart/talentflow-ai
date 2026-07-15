class ScoreService:

    @staticmethod
    def compute(result: dict) -> int:

        score = 0

        experience = result.get("experience_years", 0)

        if experience >= 15:
            score += 30
        elif experience >= 10:
            score += 25
        elif experience >= 5:
            score += 15
        else:
            score += 5

        skills = result.get("skills", [])

        # Maximum 40 points pour les compétences
        score += min(len(skills), 20) * 2

        # Bonus si un résumé est présent
        if result.get("summary"):
            score += 10

        # Bonus si les coordonnées sont complètes
        candidate = result.get("candidate", {})

        for field in ("email", "phone", "location"):
            if candidate.get(field):
                score += 5

        return min(score, 100)
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

        skills = result.get("skills", {})

        weights = {
            "languages": 10,
            "frameworks": 15,
            "devops": 15,
            "embedded": 15,
            "network": 10,
            "databases": 10,
            "ai": 15,
            "other": 5
        }

        for category, value in weights.items():

            count = len(skills.get(category, []))

            score += min(count, 5) * value / 5

        return min(round(score), 100)
import re

from app.data.skills import SKILLS, SYNONYMS


class SkillClassifier:

    @classmethod
    def preprocess(cls, skill: str) -> str:

        for old, new in SYNONYMS.items():
            skill = re.sub(
                re.escape(old),
                new,
                skill,
                flags=re.IGNORECASE
            )

        return skill

    @classmethod
    def normalize(cls, skills: list[str]) -> list[str]:

        normalized = []

        for skill in skills:

            skill = cls.preprocess(skill)

            parts = re.split(r"[(),|]+", skill)

            for part in parts:

                part = part.strip()

                if not part:
                    continue

                part = part.replace("CI_CD", "CI/CD")

                normalized.append(part)

        return sorted(set(normalized))

    @classmethod
    def classify(cls, skills: list[str]) -> dict:

        normalized = cls.normalize(skills)

        result = {
            category: []
            for category in SKILLS
        }

        result["other"] = []

        for skill in normalized:

            found = False

            skill_lower = skill.lower()

            for category, values in SKILLS.items():

                for value in values:

                    if skill_lower == value.lower():

                        result[category].append(value)

                        found = True
                        break

                if found:
                    break

            if not found:
                result["other"].append(skill)

        for category in result:
            result[category] = sorted(set(result[category]))

        return result
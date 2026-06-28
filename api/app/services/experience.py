import re
from datetime import datetime


class ExperienceService:

    @staticmethod
    def compute(text: str) -> int:

        current_year = datetime.now().year

        matches = re.findall(
            r"(20\d{2})\s*-\s*(20\d{2}|Aujourd'hui|Present|Présent)",
            text,
            flags=re.IGNORECASE
        )

        total = 0

        for start, end in matches:

            start = int(start)

            if end.lower() in (
                "aujourd'hui",
                "present",
                "présent"
            ):
                end = current_year
            else:
                end = int(end)

            if end >= start:
                total += end - start

        return total
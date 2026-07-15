from pathlib import Path

import fitz


class PDFService:

    @staticmethod
    def extract_text(pdf_path: Path) -> dict:

        document = fitz.open(pdf_path)

        text = ""

        for page in document:
            text += page.get_text()

        page_count = document.page_count

        document.close()

        return {
            "filename": pdf_path.name,
            "pages": page_count,
            "characters": len(text),
            "preview": text[:1000],
            "text": text
        }
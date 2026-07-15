from pathlib import Path
import shutil

from fastapi import APIRouter, File, Form, HTTPException, UploadFile

from app.services.pdf import PDFService
from app.services.ai import AIService

router = APIRouter(
    prefix="/cv",
    tags=["CV"]
)

UPLOAD_DIR = Path("uploads")
UPLOAD_DIR.mkdir(exist_ok=True)


@router.post("/analyze")
async def analyze_cv(
    file: UploadFile = File(...),
    job_description: str = Form("")
):
    destination = UPLOAD_DIR / Path(file.filename).name

    with destination.open("wb") as buffer:
        shutil.copyfileobj(file.file, buffer)

    pdf = PDFService.extract_text(destination)

    ai = AIService()

    try:
        return ai.analyze(
            text=pdf["text"],
            job_description=job_description
        )
    

    except Exception as e:
        raise HTTPException(
            status_code=500,
            detail=str(e)
        )    
    
    finally:
        if destination.exists():
            destination.unlink()

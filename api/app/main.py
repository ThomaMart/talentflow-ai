from fastapi import FastAPI, UploadFile, File
from pathlib import Path
import shutil

app = FastAPI(
    title="TalentFlow AI",
    version="0.1.0"
)

UPLOAD_DIR = Path("uploads")
UPLOAD_DIR.mkdir(exist_ok=True)


@app.get("/")
def root():
    return {
        "application": "TalentFlow AI"
    }


@app.get("/health")
def health():
    return {
        "status": "ok",
        "version": "0.1.0"
    }


@app.post("/cv/upload")
async def upload_cv(file: UploadFile = File(...)):
    destination = UPLOAD_DIR / file.filename

    with destination.open("wb") as buffer:
        shutil.copyfileobj(file.file, buffer)

    return {
        "success": True,
        "filename": file.filename,
        "content_type": file.content_type,
        "size": destination.stat().st_size
    }


@app.post("/cv/analyze")
def analyze_cv():
    return {
        "candidate": "Thomas Martin",
        "skills": [
            "Python",
            "Docker",
            "FastAPI",
            "WordPress",
            "CI/CD",
            "Robot Framework"
        ],
        "experience": 15,
        "score": 94,
        "summary": (
            "Experienced software integration engineer with expertise in "
            "automation, embedded systems, DevOps and AI-driven tooling."
        )
    }
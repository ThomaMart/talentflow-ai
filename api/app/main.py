from fastapi import FastAPI

app = FastAPI(
    title="TalentFlow AI API",
    version="0.1.0"
)

@app.get("/")
def root():
    return {
        "application": "TalentFlow AI",
        "status": "running"
    }

@app.get("/health")
def health():
    return {
        "status": "ok"
    }
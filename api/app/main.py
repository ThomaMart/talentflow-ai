from fastapi import FastAPI

from app.routers.health import router as health_router
from app.routers.cv import router as cv_router

app = FastAPI(
    title="TalentFlow AI",
    version="0.1.0"
)


@app.get("/")
def root():
    return {
        "application": "TalentFlow AI"
    }


app.include_router(health_router)
app.include_router(cv_router)
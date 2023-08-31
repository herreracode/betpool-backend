export default interface Prediction {
    team_away: string;
    score_away: string;
    team_local: string;
    score_local: string;
    status: string;
    id: string;
    user_id: string;
    pool_id: string;
    game_id: string;
    points_earned: string | null;
}
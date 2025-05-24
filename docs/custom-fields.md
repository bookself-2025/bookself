# 커스텀 필드

## 필드 종류

| 필드           | 타입     | 설명                           |
|--------------|--------|------------------------------|
| price        | string | 가격.                          |
| currency     | string | 통화. krw, usd, jpy, eur 만 지원. |            
| author       | string | 저자.                          |        
| press_name   | string | 출판사.                         |       
| rate         | int    | 좋아요는 양수, 싫어요는 음수             |
| release_date | string | 촐간 날짜 'Y-m-d' 형식.            |       
| isbn         | string | ISBN 10또는  13자리              |

- 제목, 도서 소개, 그리고 커버 이미지는 워드프레스 기본 기능 사용.
- 필드는 모두 접두사가 붙음.

## 기타 백로그

- 대여 상태
    - 반납함 returned
- 독서 노트 (당장 급하진 않음)
